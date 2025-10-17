<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Page d’atterrissage secteurs (3 boutons).
     */
    public function sectors()
    {
        $banner = Banner::latest()->first();
        $heroBannerImg = $banner && $banner->image
            ? asset('storage/' . ltrim($banner->image, '/'))
            : asset('img/default-banner.jpg');

        // Liste des secteurs autorisés (assure-toi d’avoir la constante dans le modèle)
        $sectors = Project::SECTEURS ?? ['Tertiaire', 'Industrie', 'Agricole'];

        // Vue à créer : resources/views/pages/project-sectors.blade.php
        return view('pages.project-sectors', compact('heroBannerImg', 'sectors'));
    }

    /**
     * Index projets. Si aucun secteur n’est fourni, on redirige vers /projects/sectors.
     * Si ?secteur=… est présent et valide, on filtre.
     */
    public function index(Request $request)
    {
        $currentSecteur = $request->query('secteur');

        // Si pas de secteur → page secteurs
        if (!$currentSecteur) {
            return redirect()->route('projects.sectors');
        }

        // Vérifie que le secteur demandé est valide
        $allowed = Project::SECTEURS ?? ['Tertiaire', 'Industrie', 'Agricole'];
        if (!in_array($currentSecteur, $allowed, true)) {
            // Secteur invalide → retourne à la page secteurs
            return redirect()->route('projects.sectors');
        }

        $banner = Banner::latest()->first();
        $heroBannerImg = $banner && $banner->image
            ? asset('storage/' . ltrim($banner->image, '/'))
            : asset('img/default-banner.jpg');

        // Filtre par secteur + eager load du service (évite N+1)
        $projects = Project::with('service')
            ->where('secteur', $currentSecteur)
            ->latest()
            ->paginate(12);

        // Vue index: resources/views/pages/project.blade.php
        return view('pages.project', compact('projects', 'heroBannerImg', 'currentSecteur'));
    }

    /**
     * Show projet.
     */
    public function show(Project $project)
    {
        $banner = Banner::latest()->first();
        $heroBannerImg = $banner && $banner->image
            ? asset('storage/' . ltrim($banner->image, '/'))
            : asset('img/default-banner.jpg');

        // Charger la relation service pour l’affichage
        $project->load('service');

        return view('pages.project-show', compact('project', 'heroBannerImg'));
    }
}
