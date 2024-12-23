<?php

namespace App\Providers;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        $activeUsers = User::where('status', '1')->get();
        $countActiveUsers = $activeUsers->count();
        view()->share('countActiveUsers',$countActiveUsers);



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
