<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $quotes = Quote::latest()->paginate(10);
        return view('admin.quotes.index', compact('quotes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Pour peupler le select secteur et les opérations possibles côté vue admin
        $secteurs   = Quote::SECTEURS;
        $secteurOps = Quote::SECTEUR_OPS;

        return view('admin.quotes.create', compact('secteurs', 'secteurOps'));
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
            'secteur'             => ['required', 'string', Rule::in(Quote::SECTEURS)],
            'operations'          => ['nullable', 'array'],
            'operations.*'        => ['string'],
            // Optionnel : le questionnaire peut être envoyé par l’admin
            'qs'                  => ['nullable', 'array'],
        ];

        $validator = Validator::make($request->all(), $rules);

        // Validation métier : opérations autorisées selon secteur + questionnaires si présents
        $validator->after(function ($v) use ($request) {
            $secteur = $request->input('secteur');
            $ops     = (array) $request->input('operations', []);
            $qs      = (array) $request->input('qs', []);

            // 1) Vérifier que toutes les opérations sont autorisées pour ce secteur
            if ($secteur) {
                $allowed = Quote::allowedOperationsFor($secteur);
                if (!empty($ops)) {
                    $invalid = collect($ops)->reject(fn($op) => in_array($op, $allowed, true));
                    if ($invalid->isNotEmpty()) {
                        $v->errors()->add(
                            'operations',
                            'Une ou plusieurs opérations ne sont pas autorisées pour le secteur choisi.'
                        );
                    }
                }
            }

            // 2) Si des questionnaires sont fournis, on applique les règles bloquantes
            // Destratificateur
            if (in_array('destratificateur', $ops, true)) {
                $h5  = $qs['destratificateur']['hauteur_ge_5'] ?? null;   // doit être 'oui'
                $zst = $qs['destratificateur']['zone_stockage'] ?? null;  // doit être 'non'
                if ($h5 !== 'oui') {
                    $v->errors()->add('qs.destratificateur.hauteur_ge_5', "Pour 'Destratificateur' : hauteur sous plafond ≥ 5 m requise.");
                }
                if ($zst !== 'non') {
                    $v->errors()->add('qs.destratificateur.zone_stockage', "Pour 'Destratificateur' : la zone ne doit pas être une zone de stockage.");
                }
            }

            // Déshumidificateur
            if (in_array('deshumidificateur', $ops, true)) {
                $sm   = $qs['deshumidificateur']['secteur_marche'] ?? null;  // doit être 'oui'
                $s200 = $qs['deshumidificateur']['surface_ge_200'] ?? null;  // doit être 'oui'
                if ($sm !== 'oui') {
                    $v->errors()->add('qs.deshumidificateur.secteur_marche', "Pour 'Déshumidificateur' : secteur marché requis (Oui).");
                }
                if ($s200 !== 'oui') {
                    $v->errors()->add('qs.deshumidificateur.surface_ge_200', "Pour 'Déshumidificateur' : surface ≥ 200 m² requise (Oui).");
                }
            }

            // Variateur (branche chambre/climatique — il suffit que la branche choisie ait 'Oui')
            if (in_array('variateur', $ops, true)) {
                $type = $qs['variateur']['type_froid'] ?? null; // 'chambre' ou 'climatique'
                if (!$type) {
                    $v->errors()->add('qs.variateur.type_froid', "Pour 'Variateur' : choisissez 'Chambre froide' ou 'Climatique'.");
                } elseif ($type === 'chambre') {
                    $ch = $qs['variateur']['chambre_ge_10'] ?? null; // doit être 'oui'
                    if ($ch !== 'oui') {
                        $v->errors()->add('qs.variateur.chambre_ge_10', "Pour 'Variateur' (Chambre froide) : puissance ≥ 10 kW requise (Oui).");
                    }
                } elseif ($type === 'climatique') {
                    $cl = $qs['variateur']['clim_ge_880'] ?? null; // doit être 'oui'
                    if ($cl !== 'oui') {
                        $v->errors()->add('qs.variateur.clim_ge_880', "Pour 'Variateur' (Climatique) : climatisation ≥ 880 kW requise (Oui).");
                    }
                }
            }
        });

        $data = $validator->validate();

        // Dédoublonner les opérations si besoin
        if (!empty($data['operations'])) {
            $data['operations'] = array_values(array_unique($data['operations']));
        }

        // On ne stocke pas qs (pas de colonne). On ne prend que les colonnes existantes :
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
            'secteur'             => ['required', 'string', Rule::in(Quote::SECTEURS)],
            'operations'          => ['nullable', 'array'],
            'operations.*'        => ['string'],
            'qs'                  => ['nullable', 'array'],
        ];

        $validator = Validator::make($request->all(), $rules);

        $validator->after(function ($v) use ($request) {
            $secteur = $request->input('secteur');
            $ops     = (array) $request->input('operations', []);
            $qs      = (array) $request->input('qs', []);

            if ($secteur) {
                $allowed = Quote::allowedOperationsFor($secteur);
                if (!empty($ops)) {
                    $invalid = collect($ops)->reject(fn($op) => in_array($op, $allowed, true));
                    if ($invalid->isNotEmpty()) {
                        $v->errors()->add('operations', 'Une ou plusieurs opérations ne sont pas autorisées pour le secteur choisi.');
                    }
                }
            }

            if (in_array('destratificateur', $ops, true)) {
                $h5  = $qs['destratificateur']['hauteur_ge_5'] ?? null;
                $zst = $qs['destratificateur']['zone_stockage'] ?? null;
                if ($h5 !== 'oui')  $v->errors()->add('qs.destratificateur.hauteur_ge_5', "Pour 'Destratificateur' : hauteur sous plafond ≥ 5 m requise.");
                if ($zst !== 'non') $v->errors()->add('qs.destratificateur.zone_stockage', "Pour 'Destratificateur' : la zone ne doit pas être une zone de stockage.");
            }

            if (in_array('deshumidificateur', $ops, true)) {
                $sm   = $qs['deshumidificateur']['secteur_marche'] ?? null;
                $s200 = $qs['deshumidificateur']['surface_ge_200'] ?? null;
                if ($sm !== 'oui')  $v->errors()->add('qs.deshumidificateur.secteur_marche', "Pour 'Déshumidificateur' : secteur marché requis (Oui).");
                if ($s200 !== 'oui') $v->errors()->add('qs.deshumidificateur.surface_ge_200', "Pour 'Déshumidificateur' : surface ≥ 200 m² requise (Oui).");
            }

            if (in_array('variateur', $ops, true)) {
                $type = $qs['variateur']['type_froid'] ?? null;
                if (!$type) {
                    $v->errors()->add('qs.variateur.type_froid', "Pour 'Variateur' : choisissez 'Chambre froide' ou 'Climatique'.");
                } elseif ($type === 'chambre') {
                    $ch = $qs['variateur']['chambre_ge_10'] ?? null;
                    if ($ch !== 'oui') $v->errors()->add('qs.variateur.chambre_ge_10', "Pour 'Variateur' (Chambre froide) : puissance ≥ 10 kW requise (Oui).");
                } elseif ($type === 'climatique') {
                    $cl = $qs['variateur']['clim_ge_880'] ?? null;
                    if ($cl !== 'oui') $v->errors()->add('qs.variateur.clim_ge_880', "Pour 'Variateur' (Climatique) : climatisation ≥ 880 kW requise (Oui).");
                }
            }
        });

        $data = $validator->validate();

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
