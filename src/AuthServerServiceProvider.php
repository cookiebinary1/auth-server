<?php

namespace Zeroone\Authserver;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

/**
 * Class AuthServerServiceProvider
 * @package Zeroone\AuthServer
 * @author  Cookie
 */
class AuthServerServiceProvider extends ServiceProvider
{
    /**
     * @var bool
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

        $this->loadMigrationsFrom(__DIR__.'/../migrations');

        // Routes
        $this->app->router->group(['namespace' => $nameSpace . 'Http\Controllers'], function () {
            require __DIR__ . '/../routes/web.php';
        });

        // Load Views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'AuthServer');

        $this->app->singleton(AuthServer::class, function ($app) {
            return new AuthServer();
        });
    }

    /**
     * @author Cookie
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/authServer.php', 'authServer'
        );
    }
}
