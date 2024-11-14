<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kanji extends Model
{
    public $timestamps = false;
    public function lecturas()
    {
        return $this->hasMany(Lectura::class);
    }
    public function significados()
    {
        return $this->hasMany(Significado::class);
    }
    public function radicales()
    {
        return $this->belongsToMany(Radical::class);
    }

    public function similares(): BelongsToMany
    {
        return $this->belongsToMany(
            Kanji::class,
            "kanji_similar",
            "kanji_id",
            "kanji_similar_id"
        );
    }

    public function estudio()
    {
        return $this->hasOne(Estudio::class);
    }
}
