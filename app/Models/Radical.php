<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Radical extends Model
{
    public $timestamps = false;

    public function kanjis(): BelongsToMany
    {
        return $this->belongsToMany(Kanji::class);
    }
}
