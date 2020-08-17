<?php

namespace rakadprakoso\cemas;

use Illuminate\Support\ServiceProvider;

class CemasServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('rakadprakoso\cemas\CemasController');
        $this->loadViewsFrom(__DIR__.'/views', 'cemas');
        
       
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';

        $this->publishes([
            __DIR__.'/assets' => public_path('rakadprakoso/cemas'),
        ], 'public');
    }
}
