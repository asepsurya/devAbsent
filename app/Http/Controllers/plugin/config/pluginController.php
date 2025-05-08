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
        // ✅ Validasi file ZIP yang di-upload
        $request->validate([
            'plugin_zip' => 'required|mimes:zip|max:10240', // 10MB Max
        ]);

        $file = $request->file('plugin_zip');

        // ✅ Ambil nama file tanpa ekstensi
        $pluginZipName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        // ✅ Simpan di folder /plugins di storage
        $pluginZipPath = $file->storeAs('plugins', $pluginZipName . '.zip');

        // ✅ Lokasi file yang disimpan
        $storagePath = storage_path('app/' . $pluginZipPath);

        // ✅ Buat nama plugin unik (biar tidak tabrakan)
        $pluginName = 'plugin' . rand(100000, 999999);

        // ✅ Path untuk ekstraksi
        $extractBasePath = storage_path('app/plugins/extracted');
        $extractPath = $extractBasePath . '/' . $pluginName;

        // ✅ Cek jika folder plugin sudah ada
        if (File::exists($extractPath)) {
            return response()->json([
                'success' => false,
                'message' => 'Plugin sudah terpasang'
            ], 400);
        }

        // ✅ Buat folder jika belum ada
        File::ensureDirectoryExists($extractPath);

        $zip = new \ZipArchive;

        if ($zip->open($storagePath) === true) {
            // ✅ Ekstrak isi ZIP ke folder tujuan
            $zip->extractTo($extractPath);
            $zip->close();

            // ✅ Path ke info.php yang wajib ada di dalam ZIP
            $infoFile = $extractPath . '/info.php';

            if (File::exists($infoFile)) {
                // ✅ Ambil konfigurasi dari info.php
                $info = include $infoFile;

                // ✅ Ambil informasi plugin
                $name_plugin = $info['name_plugin'] ?? 'Unknown Plugin';
                $version = $info['version'] ?? '1.0.0';
                $auth = $info['auth'] ?? 'Unknown';
                $description = $info['description'] ?? '';

                // ✅ Cek apakah sudah ada di database
                $existingPlugin = Plugin::where('name', $name_plugin)->first();

                if ($existingPlugin) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Plugin "' . $name_plugin . '" sudah terinstall.'
                    ], 400);
                }

                // ✅ Simpan ke database
                Plugin::create([
                    'name' => $name_plugin,
                    'alias' => $pluginName,
                    'status' => '1',
                    'version' => $version,
                    'auth' => $auth,
                    'description' => $description,
                    'api_id' => $request->api_id ?? ''
                ]);

                \Log::info('Plugin "' . $name_plugin . '" berhasil ditambahkan dengan versi: ' . $version);

                // ✅ Jalankan proses tambahan
                $this->addRoutesFromPlugin($extractPath, $pluginName);
                $this->moveControllers($extractPath);
                $this->moveViews($extractPath);
                $this->addMenu($extractPath);
                $this->addImport($extractPath);

                return response()->json([
                    'success' => true,
                    'message' => 'Plugin "' . $name_plugin . '" berhasil diimpor dan di-install!'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'File info.php tidak ditemukan di plugin.'
                ], 400);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengekstrak file plugin.'
            ], 500);
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

    public function downloadPlugin(Request $request)
    {
        $request->validate([
            'plugin_url' => 'required|url',
            'plugin_name' => 'required|string'
        ]);

        try {
            // 🔥 Ambil file dari URL eksternal menggunakan cURL agar lebih aman dan bisa handle error
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $request->plugin_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $contents = curl_exec($ch);
            $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpStatus !== 200 || !$contents) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengunduh plugin, URL tidak dapat diakses atau file tidak ditemukan.'
                ]);
            }

            // 🔥 Simpan di Laravel Storage
            $fileName = $request->plugin_name . '.zip';
            $filePath = 'plugins/' . $fileName;

            // Simpan file di storage (pastikan disk "public" sudah di-link)
            Storage::disk('local')->put($filePath, $contents);

            // 🔥 URL publik yang bisa diakses
            $publicUrl = asset('storage/' . $filePath);

            return response()->json([
                'success' => true,
                'file_path' => $publicUrl
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengunduh plugin: ' . $e->getMessage()
            ]);
        }

    }

    public function checkPluginInstalled($id)
    {
        $isInstalled = plugin::where('api_id', $id)->exists();

        return response()->json([
            'installed' => $isInstalled
        ]);
    }

    public function paymentPage($id) {
        $plugin = Plugin::where('api_id',$id)->first();
        if (!$plugin) {
            return redirect()->route('plugin.index')->with('error', 'Plugin tidak ditemukan.');
        }
        return view('plugin.payment', compact('plugin'));
    }


}
