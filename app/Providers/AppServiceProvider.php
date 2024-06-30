<?php

namespace App\Providers;


use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
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

        View::composer('*', function ($view) {
            $idclient = session('idclient');
            $locations = DB::select('SELECT DISTINCT nombien, idbien FROM viewlocationclientpaiement WHERE idclient =?', [$idclient]);

            $view->with('locations', $locations);
        });

        View::share('idclient', function() {
            return session('idclient');
        });
    }
}
