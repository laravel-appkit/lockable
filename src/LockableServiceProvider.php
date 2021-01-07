<?php

namespace AppKit\Lockable;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class LockableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'lockable');
        // $this->loadViewsFrom(__DIR__ . '/../resources/views', 'lockable');
        // $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        // $this->loadRoutesFrom(__DIR__ . '/../routes/lockable.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('lockable.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/lockable'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__ . '/../resources/assets' => public_path('vendor/lockable'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__ . '/../resources/lang' => resource_path('lang/vendor/lockable'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'lockable');

        // Register the main class to use with the facade
        $this->app->singleton('lockable', function () {
            return new Lockable();
        });

        Blueprint::macro('lockable', function () {
            /** @var \Illuminate\Database\Schema\Blueprint $this */
            $this->integer('locked_by')->nullable();
            $this->timestamp('locked_until')->nullable();
        });
    }
}
