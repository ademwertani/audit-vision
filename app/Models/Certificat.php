<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'pdf_file',
    ];

    // Pour le fichier image et pdf_file (mettre une logique si nécessaire)
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }

    public function getPdfUrlAttribute()
    {
        return asset('storage/' . $this->pdf_file);
    }
}
