<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kanji extends Model
{
    public $timestamps = false;
    public function readings(): HasMany
    {
        return $this->hasMany(Reading::class);
    }
    public function meanings(): HasMany
    {
        return $this->hasMany(Meaning::class);
    }
    public function radicals(): BelongsToMany
    {
        return $this->belongsToMany(Radical::class);
    }

    public function similarKanjis(): BelongsToMany
    {
        return $this->belongsToMany(
            Kanji::class,
            "kanji_similar",
            "kanji_id",
            "kanji_similar_id"
        );
    }

    public function study(): HasOne
    {
        return $this->hasOne(Study::class);
    }

    public function studies(): HasMany
    {
        return $this->hasMany(Study::class);
    }
}
