<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service; // ⬅️ remplace Category par Service
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index()
    {
        // ⬅️ eager-load service au lieu de category
        $projects = Project::with('service')->latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        // ⬅️ charger la liste des services pour le <select>
        $services = Service::orderBy('name')->get();
        $secteurs = Project::SECTEURS;
        return view('admin.projects.create', compact('services', 'secteurs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required','string','max:255'],
            'summary'     => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'image'       => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
            // ⬅️ remplace category_id par service_id
            'service_id'  => ['required','exists:services,id'],
            'secteur'     => ['nullable', Rule::in(Project::SECTEURS)],
        ]);

        // contient déjà service_id et secteur; on exclut seulement l'image
        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        Project::create($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        // Facultatif : s’assurer que la relation est disponible
        $project->load('service');
        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $services = Service::orderBy('name')->get();
        $secteurs = Project::SECTEURS;
        return view('admin.projects.edit', compact('project', 'services', 'secteurs'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name'        => ['required','string','max:255'],
            'summary'     => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'image'       => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
            'service_id'  => ['required','exists:services,id'], // ⬅️
            'secteur'     => ['nullable', Rule::in(Project::SECTEURS)],
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        $project->update($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully');
    }

    public function destroy(Project $project)
    {
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully');
    }
}
