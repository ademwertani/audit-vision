<?php

namespace App\Http\Controllers;
use App\Models\Banner;
use App\Models\About;
use App\Models\Team;

class AboutController extends Controller
{
    public function index()
    {
        $about = About::first();
        $teams = Team::all();
        $banner = \App\Models\Banner::latest()->first();
    $heroBannerImg = $banner && $banner->image
        ? asset('storage/'.ltrim($banner->image,'/'))
        : asset('img/default-banner.jpg');
        return view('pages.about', compact('about', 'teams','heroBannerImg'));
    }
}
