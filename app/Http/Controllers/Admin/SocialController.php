<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Social;
use Illuminate\Http\Request;

class SocialController extends Controller
{
    public function edit()
    {
        // We'll only have one record for social links
        $social = Social::firstOrCreate([]);
        return view('admin.social.edit', compact('social'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url'
        ]);

        $social = Social::firstOrCreate([]);
        $social->update($validated);

        return redirect()->route('admin.social.edit')
            ->with('success', 'Social links updated successfully!');
    }
}