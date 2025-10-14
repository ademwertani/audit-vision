<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuoteSubmitted;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

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
        $secteurs   = Quote::SECTEURS;
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
            'email'               => ['required', 'email', 'max:255'],
            'telephone'           => ['nullable', 'string', 'max:30'],
            'raison_sociale'      => ['nullable', 'string', 'max:255'],
            'adresse'             => ['nullable', 'string', 'max:255'],
            // Accepte tous les secteurs (plus de Rule::in)
            'secteur'             => ['required', 'string', 'max:255'],
            'operations'          => ['nullable', 'array'],
            'operations.*'        => ['string'],
            'qs'                  => ['nullable', 'array'],
        ];

        $validated = Validator::make($request->all(), $rules)->validate();

        if (!empty($validated['operations'])) {
            $validated['operations'] = array_values(array_unique($validated['operations']));
        }

        // 1) Enregistre la demande
        $quote = Quote::create($validated);

        // 2) Génère le PDF
        $operations = $validated['operations'] ?? [];
        $questions  = $request->input('qs', []);

        $pdf = PDF::loadView('pdf.quote', [
            'quote'      => $quote,
            'operations' => $operations,
            'questions'  => $questions,
        ]);

        // 3) Envoie les emails
        try {
            // envoi au client (adresse saisie)
            Mail::to($validated['email'])
                ->send(new QuoteSubmitted($quote, $pdf->output()));

            // copie interne (optionnelle)
            if ($admin = config('mail.from.address')) {
                Mail::to($admin)->send(new QuoteSubmitted($quote, $pdf->output()));
            }
        } catch (\Throwable $e) {
            Log::error('Échec envoi email devis: '.$e->getMessage());
        }

        return redirect()
            ->route('pages.quote')
            ->with('success', 'Quote ajoutée avec succès ! Le PDF a été envoyé à votre adresse email.');
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
            'email'               => ['required', 'email', 'max:255'],
            'telephone'           => ['nullable', 'string', 'max:30'],
            'raison_sociale'      => ['nullable', 'string', 'max:255'],
            'adresse'             => ['nullable', 'string', 'max:255'],
            // idem: accepte n'importe quel secteur
            'secteur'             => ['required', 'string', 'max:255'],
            'operations'          => ['nullable', 'array'],
            'operations.*'        => ['string'],
        ];

        $validated = Validator::make($request->all(), $rules)->validate();

        if (!empty($validated['operations'])) {
            $validated['operations'] = array_values(array_unique($validated['operations']));
        }

        $quote = Quote::findOrFail($id);
        $quote->update($validated);

        return redirect()
            ->route('pages.quote')
            ->with('success', 'Quote mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quote = Quote::findOrFail($id);
        $quote->delete();

        return redirect()
            ->route('pages.quote')
            ->with('success', 'Quote supprimée avec succès !');
    }
}
