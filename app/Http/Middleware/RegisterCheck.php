<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Setting;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cek = Setting::where('key','register')->get();
         foreach($cek as $item){
            $status = $item->value;
         }

         // Cek apakah route diizinkan
         if ($status === 'false') {
              toastr()->warning('Halaman ini belum tersedia atau pendaftaran belum dibuka. Hubungi kami untuk info lebih lanjut');
             return redirect('/login')->with('message', 'Halaman ini tidak tersedia.');
         }

         return $next($request);
    }
}
