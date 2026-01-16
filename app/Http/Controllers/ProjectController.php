<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Liste des projets (page /projects).
     */
    public function index(Request $request)
    {
        $banner = Banner::latest()->first();
        $heroBannerImg = $banner && $banner->image
            ? asset('storage/' . ltrim($banner->image, '/'))
            : asset('img/default-banner.jpg');

        // On récupère tous les projets, les plus récents d'abord
        $projects = Project::latest()->paginate(12);

        // Vue : resources/views/pages/project.blade.php
        return view('pages.project', compact('projects', 'heroBannerImg'));
    }

    /**
     * Page détail d’un projet ( /projects/{project} ).
     */
    public function show(Project $project)
    {
        $banner = Banner::latest()->first();
        $heroBannerImg = $banner && $banner->image
            ? asset('storage/' . ltrim($banner->image, '/'))
            : asset('img/default-banner.jpg');

        // Plus de service, plus de galerie → projet simple
        return view('pages.project-show', compact('project', 'heroBannerImg'));
    }
}
