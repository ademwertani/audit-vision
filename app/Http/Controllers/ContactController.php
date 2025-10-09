<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create()
    {
        // Récupérer la première bannière si elle existe, sinon image par défaut
        $heroBannerImg = optional(Banner::query()->orderByDesc('id')->first())->image;
        $heroBannerImg = $heroBannerImg
            ? asset('storage/' . ltrim($heroBannerImg, '/'))
            : asset('img/ima.png'); // <-- mets ici ton fallback (ex: img/contact-hero.jpg)

        return view('contact.create', compact('heroBannerImg'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => ['required','string','max:255'],
            'email'   => ['required','email','max:255'],
            'subject' => ['required','string','max:255'],
            'message' => ['required','string'],
        ]);

        Contact::create($validated); // Assure-toi que le modèle Contact a bien ces champs dans $fillable

        return redirect()
            ->back()
            ->with('success', 'Your message has been sent successfully!');
    }
}
