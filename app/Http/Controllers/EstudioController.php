<?php

namespace App\Http\Controllers;

use App\Models\Estudio;
use App\Models\Kanji;
use Inertia\Inertia;

class EstudioController extends Controller
{
    public function show()
    {
        //Obtenemos información del usuario
        $userId = auth()->user()->id;
        $userIndex = "indice_" . auth()->user()->indice;

        //Obtenemos último kanji estudiado (1 intento con fecha más reciente)
        $lastKanji = Estudio::where([
            ["user_id", "=", $userId],
            ["intentos", "=", 1],
        ])
            ->orderBy("fecha")
            ->first();

        //Obtenemos el indice del último kanji estudiado, si existe
        $lastKanji
            ? ($lastId = Kanji::find($lastKanji->kanji_id)->$userIndex)
            : ($lastId = 0);

        // Obtenemos los kanjis a estudiar
        $kanjis = Kanji::where($userIndex, ">", $lastId)
            ->orderBy($userIndex)
            ->limit(10)
            ->get();

        //Les añadimos sus radicales
        $kanjis->load("radicales");

        return Inertia::render("Estudio", [
            "kanjis" => $kanjis,
        ]);
    }
}
