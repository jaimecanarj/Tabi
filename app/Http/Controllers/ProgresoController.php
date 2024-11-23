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
        //Obtenemos información del usuario
        $userId = auth()->user()->id;
        $userIndex = "indice_" . auth()->user()->indice;

        //Obtenemos los kanjis con los estudios del usuario
        $kanjis = Kanji::orderBy($userIndex)->get();

        $kanjis->load([
            "estudios" => function ($query) use ($userId) {
                $query
                    ->where("user_id", "=", $userId)
                    ->orderBy("fecha", "desc");
            },
        ]);

        return Inertia::render("Progreso", ["kanjis" => $kanjis]);
    }
}
