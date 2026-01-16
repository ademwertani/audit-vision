<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\YoutubeVideo;
use Illuminate\Http\Request;

class YoutubeVideoController extends Controller
{
    // Liste des vidéos
    public function index()
    {
        $videos = YoutubeVideo::latest()->paginate(10);

        return view('admin.video.index', compact('videos'));
    }

    // Formulaire de création
    public function create()
    {
        return view('admin.video.create');
    }

    // Enregistrement d'une nouvelle vidéo
    public function store(Request $request)
    {
        $data = $request->validate([
            'url'         => 'required|url|max:255',
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        YoutubeVideo::create($data);

        return redirect()
            ->route('admin.videos.index')
            ->with('success', 'Vidéo ajoutée avec succès !');
    }

    // Formulaire d'édition
    public function edit(YoutubeVideo $video)
    {
        return view('admin.video.edit', compact('video'));
    }

    // Mise à jour d'une vidéo
    public function update(Request $request, YoutubeVideo $video)
    {
        $data = $request->validate([
            'url'         => 'required|url|max:255',
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $video->update($data);

        return redirect()
            ->route('admin.videos.index')
            ->with('success', 'Vidéo mise à jour avec succès !');
    }

    // Suppression d'une vidéo
    public function destroy(YoutubeVideo $video)
    {
        $video->delete();

        return redirect()
            ->route('admin.videos.index')
            ->with('success', 'Vidéo supprimée avec succès !');
    }
}
