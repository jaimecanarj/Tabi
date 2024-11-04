<?php

namespace App\Http\Controllers;

use App\Models\Kanji;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KanjiController extends Controller
{
    public function index()
    {
        $kanjis = Kanji::paginate(12);
        return Inertia::render("Kanjis", [
            "response" => $kanjis,
        ]);
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

    public function search(Request $request)
    {
        $literal = $request->kanji;
        $id = Kanji::where("literal", $literal)->first()->id;
        return redirect()->route("kanji", ["id" => $id]);
    }
}
