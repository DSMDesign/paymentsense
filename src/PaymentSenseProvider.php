<?php

namespace Dsm\PaymentSense;

use Illuminate\Support\ServiceProvider;

class PaymentSenseProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load views
        $this->loadViewsFrom(__DIR__ . '/views', 'payment-sense');

        // Load routes
        if (config('paymentsense.in_demo') == true) {
            $this->loadRoutesFrom(__DIR__ . '/Routes/demoroute.php');
        }

        // Load Migrations
        $this->loadMigrationsFrom(__DIR__ . '/Database/Migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->publish();
    }

    public function publish()
    {
        // Publish the public folder
        $this->publishes([
            __DIR__ . '/../Publish/Config/' => config_path(''),
        ]);
    }
}
