<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect('/login');
        }

        if(Auth()->user()->role === 'admin'){
            return redirect()->route('dashboard.admin');

        }elseif(Auth()->user()->role === 'walikelas'){
            toastr()->success('Login Berhasil');
            return redirect()->route('dashboard.walikelas');

        }elseif(Auth()->user()->role === 'guru'){
            toastr()->success('Login Berhasil');
            return redirect()->route('dashboard.teacher');

        }elseif(Auth()->user()->role === 'siswa'){
            toastr()->success('Login Berhasil');
            return redirect()->route('dashboard.student');
        }

        return $next($request);
    }
}
