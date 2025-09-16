<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\YoutubeVideo;
use Illuminate\Http\Request;

class YoutubeVideoController extends Controller
{
    public function edit()
    {
        $video = YoutubeVideo::firstOrCreate([]);
        return view('admin.video.edit', compact('video'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'url' => 'nullable|url'
        ]);

        $video = YoutubeVideo::firstOrCreate([]);
        $video->update($validated);

        return redirect()->route('admin.video.edit')
            ->with('success', 'Video updated successfully!');
    }
}
