<?php
namespace Serokuz\OneCApi;

use Illuminate\Support\ServiceProvider;

class OneCApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/one-c.php';
        $this->publishes([
            $configPath => config_path('one-c.php'),
        ],
            'config'
        );

        include __DIR__.'/routes/api.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/one-c.php';
        $this->mergeConfigFrom($configPath, 'one-c');
    }
}
