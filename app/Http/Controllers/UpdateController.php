<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;

class UpdateController extends Controller
{
    public function updateApp(Request $request)
    {
        // Menjalankan perintah Git Pull untuk memperbarui aplikasi
        try {
            // Update aplikasi dengan melakukan pull dari GitHub
            $gitPull = shell_exec('git pull origin'); // Gantilah dengan branch yang sesuai jika diperlukan

            // Update dependensi composer
            $composerUpdate = shell_exec('composer install --no-dev --optimize-autoloader');
            Artisan::call('artisan db:migrate --force');
            Artisan::call('artisan db:seed --force');
            
            // Clear cache dan config cache
            $cacheClear = shell_exec('php artisan optimize:clear');

            // Setelah pembaruan selesai, update status di cache
            Cache::put('update_available', false, now()->addHours(1)); // Menandakan pembaruan sudah selesai

            // Kembalikan status sukses jika berhasil
            return response()->json([
                'status' => 'success',
                'message' => 'Application has been updated successfully!',
                'gitPull' => $gitPull,
                'composerUpdate' => $composerUpdate,
                'cacheClear' => $cacheClear,
            ]);
            
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, catat kesalahan dan beri respons error
            Log::error('Update failed: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update the application. Please try again later.',
            ], 500);
        }
    }

    public function checkupdate(request $request){
        Artisan::call('check:updates');
        
    }
}
