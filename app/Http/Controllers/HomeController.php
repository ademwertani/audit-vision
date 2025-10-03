<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Service;
use App\Models\Project;
use App\Models\About;
use App\Models\Social;
use App\Models\Blog;
use App\Models\YoutubeVideo;
use App\Models\Stat; // <-- AJOUTE CETTE LIGNE

class HomeController extends Controller
{
    public function index()
    {
        $banners  = Banner::latest()->take(5)->get();
        $services = Service::latest()->take(9)->get();
        $projects = Project::latest()->take(9)->get();
        $about    = About::first();
        $social   = Social::first();
        $blogs    = Blog::latest('published_at')->take(3)->get();
        $video    = YoutubeVideo::first();

        $stats = Stat::orderBy('display_order')->take(3)->get(); // OK

        return view('home', compact(
            'banners','services','projects','about','social','blogs','video','stats'
        ));
    }
}
