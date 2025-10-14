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

        // Filtre par secteur et (optionnel) pagination
        $projects = Project::where('secteur', $currentSecteur)
            ->latest()
            ->paginate(12);

        // Ta vue existante d’index : resources/views/pages/project.blade.php
        // On lui passe $currentSecteur pour pouvoir l’afficher en titre si tu veux
        return view('pages.project', compact('projects', 'heroBannerImg', 'currentSecteur'));
    }

    /**
     * Show projet (inchangé).
     */
    public function show(Project $project)
    {
        $banner = Banner::latest()->first();
        $heroBannerImg = $banner && $banner->image
            ? asset('storage/' . ltrim($banner->image, '/'))
            : asset('img/default-banner.jpg');

        return view('pages.project-show', compact('project', 'heroBannerImg'));
    }
}
