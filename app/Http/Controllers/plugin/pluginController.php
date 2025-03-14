<?php

namespace App\Http\Controllers\plugin;

use ZipArchive;
use App\Models\plugin;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


class pluginController extends Controller
{
    public function index(){
        return view('plugin.index',[
            'title' => 'Plugin'
        ]);
    }

    public function showImportForm()
    {
        return view('plugin.import',[
            'title'=>'Import Plugin'
        ]);
    }

    public function importPlugin(Request $request)
    {
       // Validasi file ZIP yang di-upload
        $request->validate([
            'plugin_zip' => 'required|mimes:zip|max:10240', // 10MB Max
        ]);

        $file = $request->file('plugin_zip');
        // Ambil nama file tanpa ekstensi
        $pluginZipName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);    
        // Menyimpan file ZIP ke storage dengan nama yang diperoleh
        $pluginZipPath = $file->storeAs('plugins', $pluginZipName . '.zip');

        // Membuka dan ekstrak file ZIP
        $zip = new ZipArchive;
        $storagePath = storage_path('app/' . $pluginZipPath);

        // Tentukan nama plugin berdasarkan nama file ZIP
        $pluginName = pathinfo($pluginZipPath, PATHINFO_FILENAME);
        
        // Tentukan folder ekstraksi
        $extractBasePath = storage_path('app/plugins/extracted');
        $extractPath = $extractBasePath . '/' . $pluginName;

        // Pastikan folder tujuan ekstraksi ada
        File::ensureDirectoryExists($extractPath);

        if ($zip->open($storagePath) === true) {
            // Ekstrak file ZIP ke folder yang sudah ditentukan
            $zip->extractTo($extractPath);
            $zip->close();
        
            // Path ke file info.php yang berada di dalam plugin ZIP yang telah diekstrak
            $infoFile = $extractPath . '/info.php';
        
            if (File::exists($infoFile)) {
                // Memasukkan file info.php
                $info = include $infoFile;
        
                // Memeriksa dan mengambil data dari info.php
                $name_plugin = isset($info['name_plugin']) ? $info['name_plugin'] : 'Unknown Plugin';
                $version = isset($info['version']) ? $info['version'] : '1.0.0';
                $auth = isset($info['auth']) ? $info['auth'] : 'Unknown';
                $description = isset($info['description']) ? $info['description'] : '';
        
                // Cek apakah plugin sudah ada di database dengan nama yang sama
                $existingPlugin = Plugin::where('name', $name_plugin)->first();
        
                if ($existingPlugin) {
                    // Jika plugin sudah ada, beri pesan error dan hentikan proses
                    return redirect()->route('pluginImportForm')->with('error', 'Plugin "' . $name_plugin . '" sudah terinstall.');
                } else {
                    // Membuat entri plugin baru di database menggunakan model Plugin
                    Plugin::create([
                        'name' => $name_plugin,
                        'status' => '1', // Asumsi status aktif
                        'version' => $version,
                        'auth' => $auth,
                        'description' => $description,
                    ]);
        
                    // Log untuk memastikan data plugin berhasil disimpan
                    \Log::info('Plugin "' . $name_plugin . '" berhasil ditambahkan dengan versi: ' . $version);
        
                    // Menambahkan routes jika ada file routes.php
                    $this->addRoutesFromPlugin($extractPath);
        
                    // Memindahkan controller jika ada di dalam folder controllers
                    $this->moveControllers($extractPath);
        
                    // Pesan sukses
                    return redirect()->route('pluginImportForm')->with('success', 'Plugin "' . $name_plugin . '" berhasil diimpor dan di-install!');
                }
            } else {
                // Jika info.php tidak ditemukan, log error
                \Log::error('File info.php tidak ditemukan di: ' . $infoFile);
        
                return redirect()->route('pluginImportForm')->with('error', 'File info.php tidak ditemukan di plugin.');
            }
        } else {
            return redirect()->route('pluginImportForm')->with('error', 'Gagal mengekstrak file plugin.');
        }
    }

    private function addRoutesFromPlugin($extractPath)
    {
        // Cek apakah file routes.php ada di dalam folder plugin yang diekstrak
        $pluginRoutesFile = $extractPath . '/routes.php';

        if (File::exists($pluginRoutesFile)) {
            // Baca konten dari file routes.php plugin
            $pluginRoutesContent = File::get($pluginRoutesFile);

            // Cek controller yang digunakan dalam routes.php
            preg_match_all('/::class, (.*?)->/', $pluginRoutesContent, $matches);
            if (isset($matches[1])) {
                // Ambil controller dari matches
                foreach ($matches[1] as $controller) {
                    // Hapus spasi atau karakter lain yang tidak perlu
                    $controller = trim($controller, " '\"");
                    // Tentukan namespace untuk controller
                    $controllerNamespace = "App\\Http\\Controllers\\plugin\\" . $controller;

                    // Impor controller di atas web.php jika belum ada
                    $this->addRoutesFromPlugin($controllerNamespace);
                }
            }

            // Path file web.php di Laravel
            $webRoutesFile = base_path('routes/web.php');

            // Tambahkan konten dari plugin routes.php ke dalam routes/web.php
            File::append($webRoutesFile, "\n\n// Routes dari Plugin\n" . $pluginRoutesContent);
        }
    }

    private function moveControllers($extractPath)
    {
        $pluginControllerFile = $extractPath . '/controller/controller.php';  // Pastikan path file controller benar
        $infoFile = $extractPath . '/info.php';  // info.php ada di root ZIP setelah diekstrak
        
        // Memastikan file controller ada di dalam ZIP
        if (File::exists($pluginControllerFile)) {
            // Memastikan file info.php ada
            if (File::exists($infoFile)) {
                // Mengambil informasi dari info.php
                $info = include $infoFile;
        
                // Memastikan bahwa 'name' ada dalam array yang dikembalikan
                if (isset($info['name_controller'])) {
                    $name = $info['name_controller'];  // Misalnya 'PluginStudentController.php'
        
                    // Menentukan tujuan penyalinan file ke dalam folder controllers/Plugin
                    $destination = app_path('Http/Controllers/plugin/' . $name);
        
                    // Menyalin file controller ke dalam folder controllers/Plugin
                    File::copy($pluginControllerFile, $destination);
        
                    // Debug log untuk memastikan controller dipindahkan
                    \Log::info('Controller "' . $name . '" berhasil dipindahkan ke folder Plugin.');
                } else {
                    \Log::error('Tidak ditemukan key "name" di dalam info.php.');
                }
            } else {
                \Log::error('File info.php tidak ditemukan di: ' . $infoFile);
            }
        } else {
            \Log::error('File controller tidak ditemukan di: ' . $pluginControllerFile);
        }
        
    }
    
}
