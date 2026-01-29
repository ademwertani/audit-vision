<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',  // Raison sociale
        'siret',         // Numéro de SIRET
        'email',
        'phone',
        'subject',
        'message',
    ];
}
