<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $table = 'quotes';

    // Secteurs autorisés
    public const SECTEURS = [
        'agricole',
        'sportif',
        'enseignement',
        'sante',
        'commerce',
        'industrie',
        'hottelerie',
    ];

    // Opérations possibles globales
    public const OPS = [
        'deshumidificateur', // NB: tu as écrit "déshumidificateur"
        'destratificateur',
        'variateur',
    ];

    // Mapping secteur -> opérations autorisées
    public const SECTEUR_OPS = [
        'agricole'     => ['deshumidificateur'],
        'sportif'      => ['destratificateur'],
        'enseignement' => ['destratificateur'],
        'sante'        => ['destratificateur', 'variateur'],
        'commerce'     => ['destratificateur', 'variateur'],
        'industrie'    => ['destratificateur', 'variateur'],
        'hottelerie'   => ['variateur'],
    ];

    protected $fillable = [
        'nom_beneficiaire',
        'prenom_beneficiaire',
        'email',
        'telephone',
        'siret',            // ← AJOUT
        'raison_sociale',
        'adresse',
        'secteur',
        'operations', // JSON (array)
    ];

    protected $casts = [
        'operations' => 'array',
    ];

    /**
     * Renvoie les opérations autorisées pour un secteur donné.
     */
    public static function allowedOperationsFor(string $secteur): array
    {
        return self::SECTEUR_OPS[$secteur] ?? [];
    }
}
