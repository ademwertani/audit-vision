<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public const SECTEURS = ['Tertiaire', 'Industrie', 'Agricole'];

    protected $fillable = [
        'name', 'summary', 'description', 'image',
        'service_id',        // ⬅️ replace category_id
        'secteur',
    ];

    // ⬇️ Replace category() with service()
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
