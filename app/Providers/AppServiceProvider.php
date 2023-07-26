<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::macro('greet', function () {
            $hour = now()->format('H');
            if ($hour < 12) {
                return 'Good morning';
            }
            if ($hour < 17) {
                return 'Good afternoon';
            }
            return 'Good evening';
        });
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();
    }
}
