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
     * Bootstrap the application events.
     *
     * @return  void
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
    }

    public function register()
    {
    }

}
