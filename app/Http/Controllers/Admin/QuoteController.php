<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quotes = Quote::latest()->paginate(10);
        return view('admin.quotes.index', compact('quotes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Toujours utile pour l’UI (liste des secteurs et mapping opérations)
        $secteurs   = Quote::SECTEURS;
        $secteurOps = Quote::SECTEUR_OPS;

        return view('admin.quotes.create', compact('secteurs', 'secteurOps'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ► Même principe que côté public : aucune contrainte “métier” bloquante
        //    sur les opérations/questions, et secteur libre (string).
        $rules = [
            'nom_beneficiaire'    => ['required', 'string', 'max:255'],
            'prenom_beneficiaire' => ['nullable', 'string', 'max:255'],
            'email'               => ['nullable', 'email', 'max:255'],
            'telephone'           => ['nullable', 'string', 'max:30'],
            'raison_sociale'      => ['nullable', 'string', 'max:255'],
            'adresse'             => ['nullable', 'string', 'max:255'],
            'secteur'             => ['required', 'string', 'max:255'], // (plus de Rule::in)
            'operations'          => ['nullable', 'array'],
            'operations.*'        => ['string'],
            'qs'                  => ['nullable', 'array'], // non stocké, juste toléré
        ];

        $data = Validator::make($request->all(), $rules)->validate();

        // Dédoublonner les opérations si présent
        if (!empty($data['operations'])) {
            $data['operations'] = array_values(array_unique($data['operations']));
        }

        // On ne stocke que les colonnes du modèle
        $payload = collect($data)->only([
            'nom_beneficiaire',
            'prenom_beneficiaire',
            'email',
            'telephone',
            'raison_sociale',
            'adresse',
            'secteur',
            'operations',
        ])->toArray();

        Quote::create($payload);

        return redirect()
            ->route('admin.quotes.index')
            ->with('success', 'Demande de devis créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quote $quote)
    {
        return view('admin.quotes.show', compact('quote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quote $quote)
    {
        $secteurs   = Quote::SECTEURS;
        $secteurOps = Quote::SECTEUR_OPS;

        return view('admin.quotes.edit', compact('quote', 'secteurs', 'secteurOps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quote $quote)
    {
        $rules = [
            'nom_beneficiaire'    => ['required', 'string', 'max:255'],
            'prenom_beneficiaire' => ['nullable', 'string', 'max:255'],
            'email'               => ['nullable', 'email', 'max:255'],
            'telephone'           => ['nullable', 'string', 'max:30'],
            'raison_sociale'      => ['nullable', 'string', 'max:255'],
            'adresse'             => ['nullable', 'string', 'max:255'],
            'secteur'             => ['required', 'string', 'max:255'], // libre aussi en update
            'operations'          => ['nullable', 'array'],
            'operations.*'        => ['string'],
            'qs'                  => ['nullable', 'array'], // toléré
        ];

        $data = Validator::make($request->all(), $rules)->validate();

        if (!empty($data['operations'])) {
            $data['operations'] = array_values(array_unique($data['operations']));
        }

        $payload = collect($data)->only([
            'nom_beneficiaire',
            'prenom_beneficiaire',
            'email',
            'telephone',
            'raison_sociale',
            'adresse',
            'secteur',
            'operations',
        ])->toArray();

        $quote->update($payload);

        return redirect()
            ->route('admin.quotes.index')
            ->with('success', 'Demande de devis mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quote $quote)
    {
        $quote->delete();

        return redirect()
            ->route('admin.quotes.index')
            ->with('success', 'Demande de devis supprimée avec succès.');
    }
}
