<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Estudio extends Model
{
    use hasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function kanji(): BelongsTo
    {
        return $this->belongsTo(Kanji::class);
    }
}
