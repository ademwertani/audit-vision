<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    // Nom de la table (optionnel car Laravel déduit automatiquement "quotes")
    protected $table = 'quotes';

    // Les colonnes que tu peux remplir (fillable)
    protected $fillable = [
        'nom',
        'prenom',
        'adresse',
        'email',
    ];
}
