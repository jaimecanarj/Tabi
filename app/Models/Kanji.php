<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
