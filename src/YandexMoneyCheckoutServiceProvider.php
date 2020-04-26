<?php

namespace CodersStudio\YandexMoneyCheckout;

use Illuminate\Support\ServiceProvider;
use YandexCheckout\Client;

class YandexMoneyCheckoutServiceProvider extends ServiceProvider
{
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/yandex-money-checkout.php', 'yandex-money-checkout');

        $this->app->singleton('YandexCheckoutClient', function ($app) {
            $client = new Client();
            $client->setAuth(config('yandex-money-checkout.store_id'), config('yandex-money-checkout.secret'));
            return $client;
        });

        $this->app->singleton('YandexMoneyCheckout', function ($app) {
            return new YandexMoneyCheckout();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
       // return ['notifications'];
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'codersstudio/yandex-money-checkout');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'codersstudio/yandex-money-checkout');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }



    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/yandex-money-checkout.php' => config_path('yandex-money-checkout.php'),
        ], 'yandex-money-checkout.config');

        // Publishing the views.
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/codersstudio'),
        ], 'yandex-money-checkout.views');


        // Publishing the translation files.
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/codersstudio'),
        ], 'yandex-money-checkout.notification');

        // Registering package commands.
        // $this->commands([]);
    }
}
