<?php


namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Service;
use App\Models\Project;
use App\Models\About;
use App\Models\Social;
use App\Models\Blog;
use App\Models\YoutubeVideo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get all necessary data for the home page
        $banners = Banner::latest()->take(3)->get();
        $services = Service::latest()->get();
        $projects = Project::latest()->take(9)->get();
        $about = About::first();
        $social = Social::first();
        $blogs = Blog::latest('published_at')->take(3)->get();
        $video = YoutubeVideo::first();

        return view('home', compact(
            'banners',
            'services',
            'projects',
            'about',
            'social',
            'blogs',
            'video'
        ));
    }
}