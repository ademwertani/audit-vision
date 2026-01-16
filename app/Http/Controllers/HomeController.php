<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Service;
use App\Models\Project;
use App\Models\About;
use App\Models\Social;
use App\Models\Blog;
use App\Models\Customer;
use App\Models\YoutubeVideo;
use App\Models\Stat;
use App\Models\Partner;
use App\Models\Certificat;
class HomeController extends Controller
{
    public function index()
    {
        $banners   = Banner::latest()->take(5)->get();
        $services  = Service::latest()->take(9)->get();
        $projects  = Project::latest()->take(9)->get();
        $customers = Customer::latest()->take(6)->get();
        $about     = About::first();
        $social    = Social::first();
        $blogs     = Blog::latest('published_at')->take(3)->get();
        $videos    = YoutubeVideo::latest()->get(); // <= ICI
        $partners  = Partner::latest()->get();
        $stats     = Stat::orderBy('display_order')->take(3)->get();
        $certificat = Certificat::orderBy('created_at', 'asc')->first();

        return view('home', compact(
            'banners',
            'services',
            'projects',
            'about',
            'customers',
            'social',
            'blogs',
            'videos',   // <= utiliser "videos" (pluriel)
            'stats',
            'partners',
            'certificat'
        ));
    }
}
