<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public const SECTEURS = ['Tertiaire', 'Industrie', 'Agricole'];

    protected $fillable = [
        'name',
        'summary',
        'description',
        'image',
        'category_id',
        'secteur', // 👈 ajouté
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
