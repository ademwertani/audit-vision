<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     */
    public function index()
    {
        $projects = Project::all();
        return view('pages.project', compact('projects'));
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        return view('pages.project-show', compact('project'));
    }
}
