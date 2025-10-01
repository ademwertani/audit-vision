<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotes = Quote::all();

        return view('pages.quote', compact('quotes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $secteurs = Quote::SECTEURS;
        $secteurOps = Quote::SECTEUR_OPS;

        return view('pages.quote', compact('secteurs', 'secteurOps'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nom_beneficiaire'    => ['required', 'string', 'max:255'],
            'prenom_beneficiaire' => ['nullable', 'string', 'max:255'],
            'email'               => ['nullable', 'email', 'max:255'],
            'telephone'           => ['nullable', 'string', 'max:30'],
            'raison_sociale'      => ['nullable', 'string', 'max:255'],
            'adresse'             => ['nullable', 'string', 'max:255'],
            'secteur'             => ['required', Rule::in(Quote::SECTEURS)],
            'operations'          => ['nullable', 'array'],
            'operations.*'        => ['string'],
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function ($v) use ($request) {
            $secteur = $request->input('secteur');
            $ops     = $request->input('operations', []);

            if ($secteur) {
                $allowed = Quote::allowedOperationsFor($secteur);

                if (!empty($ops)) {
                    $invalid = collect($ops)->reject(fn($op) => in_array($op, $allowed, true));
                    if ($invalid->isNotEmpty()) {
                        $v->errors()->add('operations', 'Une ou plusieurs opérations ne sont pas autorisées pour le secteur choisi.');
                    }
                }
            }
        });

        $validated = $validator->validate();

        if (!empty($validated['operations'])) {
            $validated['operations'] = array_values(array_unique($validated['operations']));
        }

        Quote::create($validated);

        return redirect()->route('pages.quote')->with('success', 'Quote ajoutée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $quote = Quote::findOrFail($id);
        return view('pages.quote', compact('quote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $quote = Quote::findOrFail($id);
        return view('pages.quote', compact('quote'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'nom_beneficiaire'    => ['required', 'string', 'max:255'],
            'prenom_beneficiaire' => ['nullable', 'string', 'max:255'],
            'email'               => ['nullable', 'email', 'max:255'],
            'telephone'           => ['nullable', 'string', 'max:30'],
            'raison_sociale'      => ['nullable', 'string', 'max:255'],
            'adresse'             => ['nullable', 'string', 'max:255'],
            'secteur'             => ['required', Rule::in(Quote::SECTEURS)],
            'operations'          => ['nullable', 'array'],
            'operations.*'        => ['string'],
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function ($v) use ($request) {
            $secteur = $request->input('secteur');
            $ops     = $request->input('operations', []);

            if ($secteur) {
                $allowed = Quote::allowedOperationsFor($secteur);

                if (!empty($ops)) {
                    $invalid = collect($ops)->reject(fn($op) => in_array($op, $allowed, true));
                    if ($invalid->isNotEmpty()) {
                        $v->errors()->add('operations', 'Une ou plusieurs opérations ne sont pas autorisées pour le secteur choisi.');
                    }
                }
            }
        });

        $validated = $validator->validate();

        if (!empty($validated['operations'])) {
            $validated['operations'] = array_values(array_unique($validated['operations']));
        }

        $quote = Quote::findOrFail($id);
        $quote->update($validated);

        return redirect()->route('pages.quote')->with('success', 'Quote mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quote = Quote::findOrFail($id);
        $quote->delete();

        return redirect()->route('pages.quote')->with('success', 'Quote supprimée avec succès !');
    }
}
