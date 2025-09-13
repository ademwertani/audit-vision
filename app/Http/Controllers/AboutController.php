<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Team;

class AboutController extends Controller
{
    public function index()
    {
        $about = About::first();
        $teams = Team::all();
        return view('pages.about', compact('about', 'teams'));
    }
}
