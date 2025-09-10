<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Social;
use App\Models\Service;

class SettingsController extends Controller
{
    public function getSharedData()
    {
        return [
            'about' => About::first() ?? new About(),
            'social' => Social::first() ?? new Social(),
            'services' => Service::latest()->take(6)->get()
        ];
    }
}