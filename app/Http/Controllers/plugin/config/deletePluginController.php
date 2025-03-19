<?php

namespace App\Http\Controllers\plugin\config;

use App\Models\plugin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class deletePluginController extends Controller
{
    public function deletePlugin($id) {
        // Ambil informasi plugin sebelum dihapus
        $file = plugin::where('alias', $id)->first();

        if (!$file) {
            \Log::warning("Plugin dengan alias '$id' tidak ditemukan.");
            toastr()->error('Plugin tidak ditemukan.');
            return redirect()->back();
        }

        $namaFile = $file->name;

        // Hapus menu dari sidebar
        $this->removeMenu($id);
        // Hapus folder views plugin
        $this->removePluginViews($id);
        $this->removeController($id);
        $this->removeRoute($id);
        $this->removeImport($id);

        // Path utama plugin berdasarkan ID
        $pluginPath = storage_path('app/plugins/extracted/' . $id);

        // Hapus file plugin dari database
        plugin::where('alias', $id)->delete();

        // Hapus folder plugin jika ada
        if (File::exists($pluginPath)) {
            File::deleteDirectory($pluginPath);
            \Log::info("Folder plugin '$id' berhasil dihapus.");
        } else {
            \Log::warning("Folder plugin '$id' tidak ditemukan.");
        }


        toastr()->success('Plugin berhasil dihapus.');
        return redirect()->back();
    }

  private function removeMenu($id)
  {
      $pluginMenuFile = storage_path('app/plugins/extracted/' . $id . '/menu/menu.php');
      $sidebarFile = resource_path('views/partial/menu_plugin.blade.php');

      if (!File::exists($pluginMenuFile) || !File::exists($sidebarFile)) {
          Log::error("File menu.php atau menu_plugin.blade.php tidak ditemukan untuk plugin '$id'.");
          return;
      }

      // Baca isi menu.php dari plugin
      $pluginMenuContent = File::get($pluginMenuFile);

      // Baca isi menu_plugin.blade.php
      $sidebarContent = File::get($sidebarFile);

      // Hapus hanya bagian yang sesuai dengan isi menu.php plugin
      $updatedSidebar = str_replace($pluginMenuContent, '', $sidebarContent);

      // Simpan kembali file jika ada perubahan
      if ($sidebarContent !== $updatedSidebar) {
          File::put($sidebarFile, $updatedSidebar);
          Log::info("Menu dari plugin '$id' berhasil dihapus dari sidebar.");
      } else {
          Log::info("Tidak ada perubahan pada sidebar untuk plugin '$id'.");
      }

  }

  private function removePluginViews($id)
  {
      // Path ke folder view dalam plugin yang diekstrak
      $pluginViewPath = storage_path('app/plugins/extracted/' . $id . '/view/');

      // Pastikan folder view ada
      if (!File::exists($pluginViewPath)) {
          Log::error("Folder view untuk plugin '$id' tidak ditemukan.");
          return;
      }

      // Ambil daftar folder di dalam view/
      $folders = File::directories($pluginViewPath);

      foreach ($folders as $folder) {
          // Ambil hanya nama foldernya
          $folderName = basename($folder);

          // Path tujuan di resources/views/plugin/{folderName}
          $viewFolderPath = resource_path('views/plugin/' . $folderName);

          // Hapus jika ada
          if (File::exists($viewFolderPath)) {
              File::deleteDirectory($viewFolderPath);
              Log::info("Folder views '$folderName' dari plugin '$id' berhasil dihapus.");
          } else {
              Log::info("Folder views '$folderName' dari plugin '$id' tidak ditemukan di resources.");
          }
      }
  }

  private function removeController($id){
   // Path ke folder controller di dalam folder plugin yang diekstrak
   $controllerFolder = storage_path('app/plugins/extracted/' . $id . '/controller');

   // Periksa apakah folder tersebut ada
   if (File::exists($controllerFolder) && File::isDirectory($controllerFolder)) {
       // Ambil semua file dalam folder controller
       $controllerFiles = File::files($controllerFolder);

       // Loop melalui setiap file dan hapus sesuai dengan lokasinya
       foreach ($controllerFiles as $file) {
           $controllerName = $file->getFilename(); // Ambil nama file (misal: "MyController.php")

           // Path ke controller di dalam aplikasi berdasarkan nama file
           $pluginControllerPath = app_path('Http/Controllers/plugin/' . $controllerName);

           // Hapus file dari folder plugin yang diekstrak
           File::delete($file->getPathname());

           // Hapus file dari folder aplikasi jika ada
           if (File::exists($pluginControllerPath) && File::isFile($pluginControllerPath)) {
               File::delete($pluginControllerPath);
           }
       }
    }
  }

  private function removeRoute($id){
        $webRoutesFile = base_path('routes/web.php');

        // Pastikan file web.php ada
        if (!File::exists($webRoutesFile)) {
            \Log::error("File web.php tidak ditemukan.");
            return response()->json(['error' => 'File web.php tidak ditemukan.'], 404);
        }

        $webRoutesContent = File::get($webRoutesFile);

        // Regex untuk menghapus semua dari satu "// Routes dari Plugin" ke "// Routes dari Plugin" berikutnya
        $escapedId = preg_quote($id, '/'); // Escape karakter khusus pada ID
        $pattern = "/\/\/ Routes dari Plugin\s*" . $escapedId . "[\s\S]*?\/\/ End dari Plugin\s*/";


        $updatedWebRoutes = preg_replace($pattern, ' ', $webRoutesContent);

        // Simpan perubahan ke web.php hanya jika ada perubahan
        if ($updatedWebRoutes !== $webRoutesContent) {
            File::put($webRoutesFile, $updatedWebRoutes);
            return response()->json(['message' => "Semua routes dari plugin berhasil dihapus."]);
        } else {
            return response()->json(['message' => "Tidak ada rute yang dihapus."]);
        }
  }


    //   optional
    private function removeImport($id){
        $extractPath = storage_path('app/plugins/extracted/' . $id);
        $pluginViewFolder = $extractPath . '/import'; // Path sumber dalam plugin
        $destinationPath = app_path('Imports'); // Path tujuan di Laravel

        // Cek apakah folder 'import' ada dalam plugin
        if (!File::exists($pluginViewFolder)) {
            \Log::warning("Folder import tidak ditemukan dalam plugin di path: $pluginViewFolder. Proses dihentikan.");
            return null; // Hentikan proses jika folder tidak ada
        }

        // Pastikan folder tujuan ada sebelum pengecekan
        if (!File::exists($destinationPath)) {
            \Log::warning("Folder tujuan $destinationPath tidak ditemukan. Tidak ada yang dihapus.");
            return null;
        }

        // Ambil daftar file dari folder import
        $files = File::allFiles($pluginViewFolder);

        foreach ($files as $file) {
            $targetFile = $destinationPath . '/' . $file->getFilename();

            // Hapus file di tujuan hanya jika ada di folder import
            if (File::exists($targetFile)) {
                File::delete($targetFile);
                \Log::info("File {$file->getFilename()} dihapus dari folder Imports.");
            }
        }


    }


}
