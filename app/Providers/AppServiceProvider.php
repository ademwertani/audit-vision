<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; // For setting default string length
use Illuminate\Pagination\Paginator; // For pagination styling
use App\Http\Controllers\SettingsController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register any application services here
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Set default string length for MySQL
        Schema::defaultStringLength(191);

        // Use Bootstrap for pagination views
        Paginator::useBootstrap();

        // If you're using Laravel 8+ and having mixed content issues on HTTPS
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
        }

        // You can add view composers here if needed
        // View::composer('view.name', function ($view) {
        //     $view->with('key', 'value');
        // });
        $settingsController = new SettingsController();
        $sharedData = $settingsController->getSharedData();
        
        view()->share('about', $sharedData['about']);
        view()->share('social', $sharedData['social']);
        view()->share('services', $sharedData['services']);
    }
}