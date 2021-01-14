<?php

namespace Rakadprakoso\Ceemas;

use Illuminate\Routing\Router;
use Rakadprakoso\Ceemas\app\Middleware\CheckRole;
use Rakadprakoso\Ceemas\app\Middleware\CheckDashboard;
use Rakadprakoso\Ceemas\app\Models\Config;
use Rakadprakoso\Ceemas\app\Models\GlobalData;
use Rakadprakoso\Ceemas\Services\ConfigService\ConfigRepository;
use Illuminate\Support\ServiceProvider;
use View;

class CeemasServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->make('Rakadprakoso\Ceemas\app\Controllers\CeemasGlobalDataController');
        //$this->app->make('Rakadprakoso\Ceemas\app\Controllers\CeemasController');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ceemas');

        /*$this->app->singleton('Rakadprakoso\Ceemas\app\Models\GlobalData', function ($app) {
            return new GlobalData(Config::all());
        });*/

        $this->mergeConfigFrom(
            __DIR__.'/../config/ceemas-config.php',
            'ceemas-config'
        );

        // Config Repository
        $this->app->bind(
            ConfigRepository::class,
            $this->app['config']['ceemas-config.configRepository']
        );

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes/web.php';
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('ceemas_auth', CheckRole::class);
        $router->aliasMiddleware('ceemas_dashboard', CheckDashboard::class);
        //View::share($shareddata);
        /*$raka = "Raka";
        $config = resolve(ConfigRepository::class);
        $config = $config->getSiteTitle();
        View::share('globalData', $config);*/
        //View::share('globalData', GlobalData::all());

        /*$this->publishes([
            __DIR__.'/assets' => public_path('rakadprakoso/cemas'),
        ], 'public');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');*/

        // publish config
        $this->publishes([
            __DIR__
            .'/../config/ceemas-config.php' => config_path('ceemas-config.php'),
        ], 'ceemas-config');

        // publish js and css files
        $this->publishes([
            __DIR__
            .'/../resources/assets' => public_path('vendor/ceemas'),
        ], 'ceemas-assets');

        // publish migrations
        $this->publishes([
            __DIR__
            .'/../database/migrations' => database_path('migrations'),
        ], 'ceemas-migrations');
    }
}
