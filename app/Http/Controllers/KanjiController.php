<?php

namespace App\Http\Controllers;

use App\Models\Kanji;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KanjiController extends Controller
{
    public function index()
    {
        $kanjis = Kanji::all();
        return Inertia::render("Kanjis", ["kanjis" => $kanjis]);
    }

    public function show($id)
    {
        $kanji = Kanji::find($id);
        $lecturas = Kanji::find($id)->lecturas;
        $significados = Kanji::find($id)->significados;
        $radicales = Kanji::find($id)->radicales;
        $similares = Kanji::find($id)->similares;

        return Inertia::render("Kanji", [
            "kanji" => $kanji,
            "lecturas" => $lecturas,
            "significados" => $significados,
            "radicales" => $radicales,
            "similares" => $similares,
        ]);
    }
}
