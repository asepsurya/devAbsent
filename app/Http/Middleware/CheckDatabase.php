<?php

namespace App\Http\Middleware;

use select;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class CheckDatabase
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
          // Ambil database dari .env
          $database = env('DB_DATABASE');
          $username = env('DB_USERNAME');
  
          // Jika database atau username kosong, arahkan ke setup
          if (empty($database) || empty($username)) {
              return redirect('/setup-database');
          }
  
          try {
              // Cek apakah database benar-benar ada
              DB::connection()->getPdo();
          } catch (\Exception $e) {
              return redirect('/setup-database');
          }

        return $next($request);
    }
}
