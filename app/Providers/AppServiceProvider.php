<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; // For setting default string length
use Illuminate\Pagination\Paginator; // For pagination styling
use App\Http\Controllers\SettingsController;
use App\Models\Category;
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

    // ✨ مهم: ما تعمل حتى query وقت artisan (migrate, db:seed, ...)
    if ($this->app->runningInConsole()) {
        return;
    }

    // تأكد اللي الجداول موجودة قبل ما تستعملها
    if (
        !Schema::hasTable('abouts') ||
        !Schema::hasTable('socials') ||
        !Schema::hasTable('services') ||
        !Schema::hasTable('categories')
    ) {
        return;
    }

    // نفس الكود متاعك، لكن توا آمن
    $settingsController = new SettingsController();
    $sharedData = $settingsController->getSharedData();

    view()->share('about', $sharedData['about'] ?? null);
    view()->share('social', $sharedData['social'] ?? null);
    view()->share('services', $sharedData['services'] ?? null);

    // ↓ catégories + services pour le menu
    $navCategories = Category::with([
        'services:id,category_id,name' // أو حسب الأعمدة اللي عندك
    ])->orderBy('name')->get(['id','name']);

    view()->share('navCategories', $navCategories);
}
}