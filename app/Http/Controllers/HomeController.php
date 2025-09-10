<?php


namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Service;
use App\Models\Project;
use App\Models\About;
use App\Models\Social;
use App\Models\Team;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get all necessary data for the home page
        $banners = Banner::latest()->take(3)->get();
        $services = Service::latest()->take(6)->get();
        $projects = Project::latest()->take(4)->get();
        $about = About::first();
        $social = Social::first();
        $team = Team::latest()->take(6)->get();
        return view('home', compact(
            'banners',
            'services',
            'projects',
            'about',
            'social',
            'team'
        ));
    }
}