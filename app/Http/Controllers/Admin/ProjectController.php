<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('service')->latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
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
            'service_id'  => ['required','exists:services,id'],
            'secteur'     => ['nullable', Rule::in(Project::SECTEURS)],

            // ✅ validation galerie 5 images
            'images'      => ['nullable','array','max:5'],
            'images.*'    => ['image','mimes:jpeg,png,jpg,gif','max:4096'],
        ]);

        $data = $request->except(['image','images']);

        // ✅ image principale
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        // ✅ galerie images
        $gallery = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $gallery[] = $img->store('projects/gallery', 'public');
            }
        }
        $data['images'] = $gallery;

        Project::create($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Projet créé avec succès.');
    }

    public function show(Project $project)
    {
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
            'service_id'  => ['required','exists:services,id'],
            'secteur'     => ['nullable', Rule::in(Project::SECTEURS)],

            // ✅ galerie
            'images'      => ['nullable','array','max:5'],
            'images.*'    => ['image','mimes:jpeg,png,jpg,gif','max:4096'],

            // ✅ images conservées checkbox
            'keep'        => ['nullable','array'],
        ]);

        $data = $request->except(['image','images','keep']);

        // ✅ image principale
        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $data['image'] = $request->file('image')->store('projects', 'public');
        }

        // ✅ images existantes (conservées)
        $keep = $request->input('keep', []);
        $existing = $project->images ?? [];
        $gallery = array_values(array_intersect($existing, $keep));

        // ✅ nouvelles images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $gallery[] = $img->store('projects/gallery', 'public');
            }
        }

        // ✅ max 5
        $data['images'] = array_slice($gallery, 0, 5);

        $project->update($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Projet mis à jour avec succès.');
    }

    public function destroy(Project $project)
    {
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        // ✅ supprimer galerie du storage
        if (!empty($project->images)) {
            foreach ($project->images as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Projet supprimé avec succès.');
    }
}
