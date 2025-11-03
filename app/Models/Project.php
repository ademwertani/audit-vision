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
        'service_id',
        'secteur',
        'images', // galerie d’images
    ];

    protected $casts = [
        'images' => 'array', // convertir JSON → tableau
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // URLs complètes des images
    public function getImagesUrlsAttribute(): array
    {
        $files = $this->images ?? [];
        return array_map(fn ($path) => \Illuminate\Support\Facades\Storage::url($path), $files);
    }
}
