<?php

namespace App\Http\Controllers;
use App\Models\Banner;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     */
    public function index()
    {
        $banner = \App\Models\Banner::latest()->first();
    $heroBannerImg = $banner && $banner->image
        ? asset('storage/'.ltrim($banner->image,'/'))
        : asset('img/default-banner.jpg');
        $projects = Project::all();
        return view('pages.project', compact('projects','heroBannerImg'));
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
                $banner = \App\Models\Banner::latest()->first();
    $heroBannerImg = $banner && $banner->image
        ? asset('storage/'.ltrim($banner->image,'/'))
        : asset('img/default-banner.jpg');
        return view('pages.project-show', compact('project','heroBannerImg'));
    }
    }

