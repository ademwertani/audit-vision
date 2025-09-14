<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    // Add this method
    public function edit()
    {
        $about = About::first(); // Get the first (or only) about entry
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'summary' => 'required|string',
            'location' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'aboutimage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $about = About::firstOrCreate([]);

        if ($request->hasFile('logo')) {
            if ($about->logo) {
                Storage::disk('public')->delete($about->logo);
            }
            $validated['logo'] = $request->file('logo')->store('about', 'public');
        } elseif ($request->boolean('remove_logo')) {
            if ($about->logo) {
                Storage::disk('public')->delete($about->logo);
            }
            $validated['logo'] = null;
        }

        if ($request->hasFile('aboutimage')) {
            if ($about->aboutimage) {
                Storage::disk('public')->delete($about->aboutimage);
            }
            $validated['aboutimage'] = $request->file('aboutimage')->store('about', 'public');
        } elseif ($request->boolean('remove_aboutimage')) {
            if ($about->aboutimage) {
                Storage::disk('public')->delete($about->aboutimage);
            }
            $validated['aboutimage'] = null;
        }

        $about->update($validated);

        return redirect()->route('admin.about.edit')
            ->with('success', 'About information updated successfully!');
    }
}