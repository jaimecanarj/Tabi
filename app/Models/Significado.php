<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Significado extends Model
{
    public function kanji()
    {
        return $this->belongsTo(Kanji::class);
    }
}
