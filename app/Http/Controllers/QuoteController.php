<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;  
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuoteSubmitted;
// Si tu n’as pas d’alias "PDF" dans config/app.php, appelle la FQCN :
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
        // on accepte aussi les questions dynamiques si présentes :
        'qs'                  => ['nullable', 'array'],
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

    // 1) On enregistre
    $quote = Quote::create($validated);

    // 2) On génère le PDF à partir d’une vue dédiée
    $operations = $validated['operations'] ?? [];
    $questions  = $request->input('qs', []);

    $pdf = PDF::loadView('pdf.quote', [
        'quote'      => $quote,
        'operations' => $operations,
        'questions'  => $questions,
    ]);

    // 3) On envoie l’email avec le PDF en pièce jointe
    try {
        Mail::to('adem.wartani100@gmail.com')
            ->send(new QuoteSubmitted($quote, $pdf->output()));
    } catch (\Throwable $e) {
        // En cas d’échec email, on log mais on ne casse pas le flux utilisateur
        Log::error('Échec envoi email devis: '.$e->getMessage());
        // (Optionnel) notifier en session:
        // return back()->with('success', 'Quote ajoutée avec succès, mais l\'email n\'a pas pu être envoyé.')->withInput();
    }

    return redirect()->route('pages.quote')->with('success', 'Quote ajoutée avec succès ! Le PDF a été envoyé par email.');
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
