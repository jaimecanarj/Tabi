<?php

namespace App\Http\Controllers;

use App\Models\Kanji;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Database\Eloquent\Collection;

class ProgresoController extends Controller
{
    public function index(): Response
    {
        $kanjis = ProgresoController::getKanjis();

        return Inertia::render("Progreso", ["kanjis" => $kanjis]);
    }

    private function getKanjis(): Collection
    {
        //Obtenemos información del usuario
        $userId = auth()->user()->id;
        $userIndex = "indice_" . auth()->user()->indice;

        //Obtenemos los kanjis en estudios del usuario
        return Kanji::whereIn("id", function ($query) use ($userId) {
            $query
                ->select("kanji_id")
                ->from("estudios")
                ->where("user_id", "=", $userId);
        })
            ->orderBy($userIndex)
            ->get();
    }
}
