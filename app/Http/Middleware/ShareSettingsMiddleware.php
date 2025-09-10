<?php

namespace App\Http\Middleware;

use App\Http\Controllers\SettingsController;
use Closure;

class ShareSettingsMiddleware
{
    public function handle($request, Closure $next)
    {
        $settingsController = new SettingsController();
        foreach ($settingsController->getSharedData() as $key => $value) {
            view()->share($key, $value);
        }
        
        return $next($request);
    }
}