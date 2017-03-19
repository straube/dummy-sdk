<?php

namespace Straube\Dummy\Laravel;

use Illuminate\Support\ServiceProvider;
use Straube\Dummy\Client;

/**
 * Service provider to integrate the SDK with Laravel.
 *
 * @version 1.0.0
 * @author  Gustavo Straube
 */
class DummyServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config.php' => config_path('dummy.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'dummy');

        $this->app->singleton('dummy.config', function ($app) {
            return $this->app['config']['dummy'];
        });

        $this->app->singleton(Client::class, function ($app) {
            $config = $app['dummy.config'];
            return new Client($config['username'], $config['password']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Client::class,
        ];
    }
}
