<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('category')->latest()->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $categories = Category::all();
        // On passera la constante des secteurs à la vue si besoin d'afficher le <select>
        $secteurs = Project::SECTEURS;
        return view('admin.projects.create', compact('categories', 'secteurs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => ['required','string','max:255'],
            'summary'     => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'image'       => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
            'category_id' => ['nullable','exists:categories,id'],
            'secteur'     => ['nullable', Rule::in(Project::SECTEURS)], // 👈 nouveau
        ]);

        // contient déjà 'secteur' (on exclut seulement l'image)
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
        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $categories = Category::all();
        $secteurs   = Project::SECTEURS; // pour le <select> dans la vue
        return view('admin.projects.edit', compact('project', 'categories', 'secteurs'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name'        => ['required','string','max:255'],
            'summary'     => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'image'       => ['nullable','image','mimes:jpeg,png,jpg,gif','max:2048'],
            'category_id' => ['nullable','exists:categories,id'],
            'secteur'     => ['nullable', Rule::in(Project::SECTEURS)], // 👈 nouveau
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
