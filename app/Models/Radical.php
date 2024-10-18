<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Radical extends Model
{
    public $timestamps = false;

    public function kanjis()
    {
        return $this->belongsToMany(Kanji::class);
    }
}
