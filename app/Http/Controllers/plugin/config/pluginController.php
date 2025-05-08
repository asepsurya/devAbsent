<?php

namespace App\Http\Controllers\plugin\config;

use ZipArchive;
use App\Models\plugin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


class pluginController extends Controller
{
    public function index(){
        $data = request('data');
        if ($data == 'active') {
            $plugin = Plugin::where('status', 1)->get();

        } elseif($data == 'nonactive'){
            $plugin = Plugin::where('status', 2)->get();
        }else{
            $plugin = Plugin::all();
        }

        return view('plugin.index',[
            'title' => 'Plugin',
            'data'=> $plugin

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
        $pluginPath = 'plugins/' . $pluginZipName . '.zip';


        // Menyimpan file ZIP ke storage dengan nama yang diperoleh
        $pluginZipPath = $file->storeAs('plugins', $pluginZipName . '.zip');

        // Membuka dan ekstrak file ZIP
        $zip = new ZipArchive;
        $storagePath = storage_path('app/' . $pluginZipPath);

        // Tentukan nama plugin berdasarkan nama file ZIP
        // $pluginName = pathinfo($pluginZipPath, PATHINFO_FILENAME);
        $pluginName = 'plugin' . rand(100000, 999999);

        // Tentukan folder ekstraksi
        $extractBasePath = storage_path('app/plugins/extracted');
        $extractPath = $extractBasePath . '/' . $pluginName;
         // **Cek apakah plugin dengan nama ini sudah ada**
        if (Storage::exists($pluginName)) {
            toastr()->info('Plugin Sudah Terpasang');
            return redirect()->back();
         }
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
                    toastr()->warning( 'Plugin "' . $name_plugin . '" sudah terinstall.');
                    return redirect()->route('plugin.index');
                } else {

                    // Membuat entri plugin baru di database menggunakan model Plugin
                    Plugin::create([
                        'name' => $name_plugin,
                        'alias'=>$pluginName,
                        'status' => '1', // Asumsi status aktif
                        'version' => $version,
                        'auth' => $auth,
                        'description' => $description,
                    ]);

                    // Log untuk memastikan data plugin berhasil disimpan
                    \Log::info('Plugin "' . $name_plugin . '" berhasil ditambahkan dengan versi: ' . $version);

                    // Menambahkan routes jika ada file routes.php
                    $this->addRoutesFromPlugin($extractPath, $pluginName);
                    // Memindahkan controller jika ada di dalam folder controllers
                    $this->moveControllers($extractPath);
                    // memindahan folder view
                    $this->moveViews($extractPath);
                    // menambah menu
                    $this->addMenu($extractPath);
                    // optional import
                    $this->addImport($extractPath);

                    toastr()->success('Plugin "' . $name_plugin . '" berhasil diimpor dan di-install!');
                    // Pesan sukses
                    return redirect()->route('plugin.index');
                }
            } else {
                toastr()->warning('File info.php tidak ditemukan di plugin.');
                return redirect()->route('plugin.index');
            }
        } else {
            toastr()->error('Gagal mengekstrak file plugin.');
            return redirect()->route('plugin.index');
        }
    }

    private function addRoutesFromPlugin($extractPath , $pluginName)
    {

        $pluginRouteFolder = $extractPath . '/routes'; // Path sumber dalam plugin
        $destinationPath = base_path('routes/plugins');

        // Cek apakah folder 'routes' ada dalam plugin
        if (!File::exists($pluginRouteFolder)) {
            \Log::warning('Folder routes tidak ditemukan dalam plugin. Proses dihentikan.');
            return null; // Hentikan proses jika folder tidak ada
        }

        if (File::exists($pluginRouteFolder)) {
            // Buat folder tujuan jika belum ada
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Menyalin seluruh folder dan isinya ke dalam routes/plugins
            File::copyDirectory($pluginRouteFolder, $destinationPath);
            \Log::info('Routes dari plugin berhasil dipindahkan ke folder routes/plugins.');
        }
    }

    private function moveControllers($extractPath)
    {

        $pluginViewFolder = $extractPath . '/controller'; // Path sumber dalam plugin
        $destinationPath = app_path('/Http/Controllers/plugin/');

        // Cek apakah folder 'import' ada dalam plugin
        if (!File::exists($pluginViewFolder)) {
            \Log::warning('Folder import tidak ditemukan dalam plugin. Proses dihentikan.');
            return null; // Hentikan proses jika folder tidak ada
        }

        if (File::exists($pluginViewFolder)) {
            // Buat folder tujuan jika belum ada
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            // Menyalin seluruh folder dan isinya
            File::copyDirectory($pluginViewFolder, $destinationPath);
            \Log::info('Views dari plugin berhasil dipindahkan ke folder Plugin.');
        }

    }

    private function moveViews($extractPath){
        $pluginViewFolder = $extractPath . '/view'; // Path sumber dalam plugin
        $destinationPath = resource_path('views/plugin'); // Path tujuan di Laravel

        if (File::exists($pluginViewFolder)) {
            // Buat folder tujuan jika belum ada
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Menyalin seluruh folder dan isinya
            File::copyDirectory($pluginViewFolder, $destinationPath);

            \Log::info('Views dari plugin berhasil dipindahkan ke folder Plugin.');
        }
    }

    private function addMenu($extractPath){
        $pluginMenuFile = $extractPath . '/menu/menu.php'; // Path sumber dalam plugin
        $sidebarFile = resource_path('views/partial/menu_plugin.blade.php'); // Path sidebar.blade.php

        if (File::exists($pluginMenuFile) && File::exists($sidebarFile)) {
            // Baca isi menu.php
            $pluginMenuContent = File::get($pluginMenuFile);

            // Baca isi sidebar.blade.php
            $sidebarContent = File::get($sidebarFile);

            // Sisipkan $pluginMenuContent ke dalam elemen dengan ID "plugin"
            $updatedSidebar = preg_replace(
                '/(<div[^>]+id=["\']plugin["\'][^>]*>)/i',
                "$1\n" . $pluginMenuContent,
                $sidebarContent
            );

            // Simpan perubahan ke sidebar.blade.php
            File::put($sidebarFile, $updatedSidebar);

            \Log::info('Menu dari plugin berhasil ditambahkan ke sidebar.');
        } else {
            \Log::error('File menu.php atau sidebar.blade.php tidak ditemukan.');
        }

    }

    // optional
    private function addImport($extractPath){
        $pluginViewFolder = $extractPath . '/import'; // Path sumber dalam plugin
        $destinationPath = app_path('/Imports');

        // Cek apakah folder 'import' ada dalam plugin
        if (!File::exists($pluginViewFolder)) {
            \Log::warning('Folder import tidak ditemukan dalam plugin. Proses dihentikan.');
            return null; // Hentikan proses jika folder tidak ada
        }

        if (File::exists($pluginViewFolder)) {
            // Buat folder tujuan jika belum ada
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            // Menyalin seluruh folder dan isinya
            File::copyDirectory($pluginViewFolder, $destinationPath);
            \Log::info('Views dari plugin berhasil dipindahkan ke folder Plugin.');
        }
    }


    public function store(){
        return view('plugin.store',[
            'title' => 'Plugin Store'
        ]);
    }


}
