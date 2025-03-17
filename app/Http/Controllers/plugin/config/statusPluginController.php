<?php

namespace App\Http\Controllers\plugin\config;

use App\Models\plugin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class statusPluginController extends Controller
{
    public function statusPlugin(){
        $id = request('val');
        if(request('class')== 'nonactive'){
            plugin::where('alias',$id)->update([
                'status'=> '2'
            ]);
            $this->nonActive($id);
            $this->nonActiveMenu($id);
            toastr()->info( 'Plugin Berhasil di Nonaktifan');
        }else{
            plugin::where('alias',$id)->update([
                'status'=> '1'
            ]);
            $this->active($id);
            $this->ActiveMenu($id);
            toastr()->info( 'Plugin Berhasil di Aktifan');
        }
      
        return redirect()->back();
    }

    private function nonActive($id){
      
        $webRoutesFile = base_path('routes/web.php');

        // Pastikan file web.php ada
        if (!File::exists($webRoutesFile)) {
            \Log::error("File web.php tidak ditemukan.");
            return response()->json(['error' => 'File web.php tidak ditemukan.'], 404);
        }

        $webRoutesContent = File::get($webRoutesFile);

        // Escape karakter khusus pada ID
        $escapedId = preg_quote($id, '/');

        // Pola regex untuk mencari blok rute plugin berdasarkan ID
        $pattern = "/(\/\/ Routes dari Plugin\s*" . $escapedId . "[\s\S]*?\/\/ End dari Plugin\s*)/";

        // Cek apakah sudah dalam komentar
        if (preg_match("/\/\*.*$escapedId.*\*\//s", $webRoutesContent)) {
            // Jika sudah dikomentari, kembalikan ke keadaan aktif
            $updatedWebRoutes = preg_replace("/\/\*(\s*\/\/ Routes dari Plugin\s*" . $escapedId . "[\s\S]*?\/\/ End dari Plugin\s*)\*\//s", "$1", $webRoutesContent);
            $message = "Routes dari plugin '$id' telah diaktifkan kembali.";
        } else {
            // Jika belum dikomentari, bungkus dalam komentar PHP
            $updatedWebRoutes = preg_replace($pattern, "/*$1*/", $webRoutesContent);
            $message = "Routes dari plugin '$id' telah dikomentari.";
        }

        // Simpan perubahan hanya jika ada perubahan
        if ($updatedWebRoutes !== $webRoutesContent) {
            File::put($webRoutesFile, $updatedWebRoutes);
            return response()->json(['message' => $message]);
        } else {
            return response()->json(['message' => "Tidak ada perubahan pada rute untuk plugin '$id'."]);
        }


    }

    private function  active($id){
        $webRoutesFile = base_path('routes/web.php');

        // Pastikan file web.php ada
        if (!File::exists($webRoutesFile)) {
            \Log::error("File web.php tidak ditemukan.");
            return response()->json(['error' => 'File web.php tidak ditemukan.'], 404);
        }

        $webRoutesContent = File::get($webRoutesFile);

        // Escape karakter khusus pada ID plugin
        $escapedId = preg_quote($id, '/');

        // Regex untuk mencari blok rute plugin yang dikomentari
        $pattern = "/\/\*(\s*\/\/ Routes dari Plugin\s*" . $escapedId . "[\s\S]*?\/\/ End dari Plugin\s*)\*\//s";

        // Hapus komentar jika ditemukan
        if (preg_match($pattern, $webRoutesContent)) {
            $updatedWebRoutes = preg_replace($pattern, "$1", $webRoutesContent);
            $message = "Komentar pada rute plugin '$id' telah dihapus dan diaktifkan kembali.";
        } else {
            $updatedWebRoutes = $webRoutesContent;
            $message = "Tidak ada komentar yang perlu dihapus untuk rute plugin '$id'.";
        }

        // Simpan perubahan hanya jika ada perubahan
        if ($updatedWebRoutes !== $webRoutesContent) {
            File::put($webRoutesFile, $updatedWebRoutes);
            return response()->json(['message' => $message]);
        } else {
            return response()->json(['message' => "Tidak ada perubahan pada rute untuk plugin '$id'."]);
        }

    }

    private function ActiveMenu($id){
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

        // Escape konten agar aman dalam regex
        $escapedMenuContent = preg_quote($pluginMenuContent, '/');

        // Cek apakah sudah dikomentari sebelumnya
        $pattern = "/{{--\s*" . $escapedMenuContent . "\s*--}}/s";

        if (preg_match($pattern, $sidebarContent)) {
            // Jika dalam komentar, kembalikan ke keadaan aktif
            $updatedSidebar = preg_replace($pattern, $pluginMenuContent, $sidebarContent);
            Log::info("Menu plugin '$id' diaktifkan kembali.");
        } else {
            // Jika belum dikomentari, bungkus dalam komentar Blade
            $updatedSidebar = str_replace($pluginMenuContent, "{{--\n" . $pluginMenuContent . "\n--}}", $sidebarContent);
            Log::info("Menu plugin '$id' berhasil dikomentari di sidebar.");
        }

        // Simpan perubahan jika ada perubahan
        if ($sidebarContent !== $updatedSidebar) {
            File::put($sidebarFile, $updatedSidebar);
        } else {
            Log::info("Tidak ada perubahan pada sidebar untuk plugin '$id'.");
        }

    }

    private function NonActiveMenu($id){
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

        // Escape konten agar aman dalam regex
        $escapedMenuContent = preg_quote($pluginMenuContent, '/');

        // Cek apakah sudah dikomentari sebelumnya
        $pattern = "/{{--\s*" . $escapedMenuContent . "\s*--}}/s";

        if (preg_match($pattern, $sidebarContent)) {
            Log::info("Menu plugin '$id' sudah dalam bentuk komentar.");
        } else {
            // Bungkus menu dalam komentar Blade
            $updatedSidebar = str_replace($pluginMenuContent, "{{--\n" . $pluginMenuContent . "\n--}}", $sidebarContent);

            // Simpan perubahan jika ada perubahan
            if ($sidebarContent !== $updatedSidebar) {
                File::put($sidebarFile, $updatedSidebar);
                Log::info("Menu dari plugin '$id' berhasil dikomentari di sidebar.");
            } else {
                Log::info("Tidak ada perubahan pada sidebar untuk plugin '$id'.");
            }
        }

    }
}
