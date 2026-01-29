<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create()
    {
        // Récupérer la bannière
        $heroBannerImg = optional(Banner::query()->orderByDesc('id')->first())->image;
        $heroBannerImg = $heroBannerImg
            ? asset('storage/' . ltrim($heroBannerImg, '/'))
            : asset('img/ima.png');

        return view('contact.create', compact('heroBannerImg'));
    }

    public function store(Request $request)
{
    // Validation conforme au formulaire
    $validated = $request->validate([
        'company_name' => ['required', 'string', 'max:255'],  // Validation pour la raison sociale
        'siret' => ['required', 'digits:14'],  // Validation pour le numéro de SIRET (14 chiffres)
        'email' => ['required', 'email', 'max:255'],
        'phone' => ['nullable', 'string', 'max:255'],
        'subject' => ['nullable', 'string', 'max:255'],
        'message' => ['required', 'string'],
    ]);

    // Enregistrement en base
    Contact::create($validated);

    return redirect()
        ->back()
        ->with('success', 'Votre message a été envoyé avec succès !');
}

}
