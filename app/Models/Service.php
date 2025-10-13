<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'summary',
        'description',
        'image',
        'category_id',
        'youtube_url',   // ← nouveau champ
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /** Retourne l'ID YouTube quelle que soit la forme du lien saisi */
    public function getYoutubeIdAttribute(): ?string
    {
        $url = $this->youtube_url;
        if (!$url) return null;

        // youtu.be/XXXXX
        if (preg_match('~youtu\.be/([a-zA-Z0-9_-]{6,})~', $url, $m)) return $m[1];

        // youtube.com/watch?v=XXXXX (gère aussi &t= etc.)
        if (preg_match('~[?&]v=([a-zA-Z0-9_-]{6,})~', $url, $m)) return $m[1];

        // youtube.com/embed/XXXXX
        if (preg_match('~embed/([a-zA-Z0-9_-]{6,})~', $url, $m)) return $m[1];

        return null;
    }

    /** URL d'embed prête pour un <iframe> */
    public function getYoutubeEmbedAttribute(): ?string
    {
        return $this->youtube_id ? 'https://www.youtube.com/embed/' . $this->youtube_id : null;
    }
}
