<?php

namespace App\Providers;
use Carbon\Carbon;
use App\Models\User;
use App\Models\absent;
use App\Models\Setting;
use App\Models\TahunPelajaran;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    protected $listen = [
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogSuccessfulLogin',
        ],
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('users')) {
            // Ambil pengguna aktif
            $countActiveUsers = User::where('status', '1')->count();
        } else {
            // Jika tabel users tidak ada, set nilai default untuk menghindari error
            $countActiveUsers = 0;
        }
        // Pastikan tabel `tahun_pelajaran` ada sebelum melakukan query
        if (Schema::hasTable('tahun_pelajarans')) {
            $akademik = TahunPelajaran::where('status', '1')->first();
        } else {
            $akademik = null;
        }

        if (config('app.env') === 'production') { URL::forceScheme('https'); }
        $updateAvailable = Cache::get('update_available', false); // Mengambil status pembarua

        // Gunakan optional() untuk menghindari error jika data tidak ditemukan
        $tahunAjaran = optional($akademik)->tahun_pelajaran
                       ? optional($akademik)->tahun_pelajaran . ' - ' . optional($akademik)->semester
                       : 'Tidak ada data';

        // Bagikan data ke semua tampilan agar bisa digunakan di blade
        view()->share('countActiveUsers', $countActiveUsers);
        view()->share('tahunAjaran', $tahunAjaran);
        view()->share('updateAvailable', $updateAvailable);

        // ubah lokasi ke Indi
        config(['app.locale' => 'id']);
	    Carbon::setLocale('id');

        // user super Admin
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('superadmin')) {
                return true;
            }
        });

        // paginator
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();

        // App Settings
        $this->app->singleton('settings',function(){
            return Cache::rememberForever('settings', function () {
                return Setting::all()->pluck('value','key');
            });
        });

    }
}
