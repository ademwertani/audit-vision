<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Stat extends Model
{
protected $fillable = ['label','slug','value','is_accent','display_order'];
    protected $casts = ['is_accent' => 'boolean'];

    protected static function booted(): void
    {
        static::saving(function (Stat $stat) {
            if (empty($stat->slug)) {
                $stat->slug = Str::slug($stat->label);
            }
        });
    }

    public function scopeOrdered($q) { return $q->orderBy('display_order'); }
}
