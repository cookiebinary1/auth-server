<?php

namespace Zeroone\Authserver;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use App\User;

/**
 * Class AuthServerServiceProvider
 * @package Zeroone\AuthServer
 * @author  Martin Osusky
 */
class AuthServerServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = false;

    /**
     * @author Martin Osusky
     */
    public function boot()
    {
        $nameSpace = $this->app->getNamespace();

        AliasLoader::getInstance()->alias('AuthServerAppController', $nameSpace . 'Http\Controllers\Controller');

        $this->loadMigrationsFrom(__DIR__ . '/../migrations');

        $this->app->router->group(['namespace' => $nameSpace . 'Http\Controllers'], function () {
            require __DIR__ . '/../routes/web.php';
        });

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'AuthServer');

        $this->app->singleton(AuthServer::class, function ($app) {
            return new AuthServer();
        });
    }

    /**
     * @author Martin Osusky
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/authServer.php', 'authServer'
        );
    }
}
