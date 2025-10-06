<?php

namespace App\Http\Controllers;
use App\Models\Banner;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    
    public function create()
    {
        return view('contact.create');
    }

    public function store(Request $request)
    {
        $banner = \App\Models\Banner::latest()->first();
    $heroBannerImg = $banner && $banner->image
        ? asset('storage/'.ltrim($banner->image,'/'))
        : asset('img/default-banner.jpg');
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return redirect()->back()
            ->with('success', 'Your message has been sent successfully!','heroBannerImg');
    }
}