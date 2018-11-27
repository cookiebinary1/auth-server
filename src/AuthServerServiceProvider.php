<?php

namespace Zeroone\AuthServer;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class AuthServerServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var  bool
     */
    protected $defer = false;

    /**
     * @author Cookie
     */
    public function boot()
    {
        // Get namespace
        $nameSpace = $this->app->getNamespace();

        AliasLoader::getInstance()->alias('AuthServerAppController', $nameSpace . 'Http\Controllers\Controller');

        // Routes
        $this->app->router->group(['namespace' => $nameSpace . 'Http\Controllers'], function () {
            require __DIR__ . '/../routes/web.php';
        });

        // Load Views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'AuthServer');

        $this->app->singleton(AuthServer::class, function($app) {
            return new AuthServer();
        });
    }

    /**
     * @author Cookie
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/authServer.php', 'authServer'
        );
    }

}
