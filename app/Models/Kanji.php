<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kanji extends Model
{
    public $timestamps = false;
    public function lecturas(): HasMany
    {
        return $this->hasMany(Lectura::class);
    }
    public function significados(): HasMany
    {
        return $this->hasMany(Significado::class);
    }
    public function radicales(): BelongsToMany
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

    public function estudio(): HasOne
    {
        return $this->hasOne(Estudio::class);
    }
}
