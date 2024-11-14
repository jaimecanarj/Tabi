<?php

namespace App\Http\Controllers;

use App\Models\Kanji;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProgresoController extends Controller
{
    public function index()
    {
        $kanjis = ProgresoController::getKanjis();

        return Inertia::render("Progreso", ["kanjis" => $kanjis]);
    }

    private function getKanjis()
    {
        //Obtenemos información del usuario
        $userId = auth()->user()->id;
        $userIndex = "indice_" . auth()->user()->indice;

        //Obtenemos los kanjis en estudios del usuario
        $kanjis = Kanji::whereIn("id", function ($query) use ($userId) {
            $query
                ->select("kanji_id")
                ->from("estudios")
                ->where("user_id", "=", $userId);
        })
            ->orderBy($userIndex)
            ->get();

        return $kanjis;
    }
}
