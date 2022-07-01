<?php

namespace App\Library\Web;

use Illuminate\Support\ServiceProvider;

class WebServiceProvider extends ServiceProvider
{

    protected $routeMiddleware = [
        'home.auth'       => \App\Library\Web\Middleware\Authenticate::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'home' => [
            'home.auth',
        ],
    ];

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadAdminAuthConfig();
        $this->registerRouteMiddleware();
        $this->loadViewsFrom(app_path('Web/views'), 'web');
        $this->loadRoutesFrom(app_path('Web/routes/routes.php'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton("web", function($app){
            return new Web();
        });

    }

    /**
     * Setup auth configuration.
     *
     * @return void
     */
    protected function loadAdminAuthConfig()
    {
        config(array_dot(config('web.auth', []), 'auth.'));
    }

    /**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware()
    {

        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }

        // register middleware group.
        foreach ($this->middlewareGroups as $key => $middleware) {
            app('router')->middlewareGroup($key, $middleware);
        }

    }
}
