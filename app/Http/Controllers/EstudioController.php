<?php

namespace App\Http\Controllers;

use App\Models\Estudio;
use App\Models\Kanji;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Database\Eloquent\Collection;

class EstudioController extends Controller
{
    public function show(): Response
    {
        $kanjis = EstudioController::getStudyKanjis();

        return Inertia::render("Estudio", [
            "kanjis" => $kanjis,
        ]);
    }

    public function review(): Response
    {
        //Comprobamos si venimos de estudiar u otro lugar
        $urlArray = explode("/", url()->previous());
        $lastUrl = end($urlArray);
        //De estudiar
        if ($lastUrl == "estudiar") {
            $kanjis = EstudioController::getStudyKanjis();

            return Inertia::render("Repaso", [
                "kanjis" => $kanjis,
            ]);
        }

        //De repasar
        $userId = auth()->user()->id;

        $kanjis = Kanji::whereIn("id", function ($query) use ($userId) {
            $query
                ->select("kanji_id")
                ->from("estudios")
                ->where("user_id", "=", $userId);
        })->get();

        //Obtener último estudio de cada kanji
        $kanjis->load([
            "estudio" => function ($query) use ($userId) {
                $query
                    ->where("user_id", "=", $userId)
                    ->orderBy("fecha", "desc");
            },
            "radicales",
        ]);

        return Inertia::render("Repaso", [
            "kanjis" => $kanjis,
        ]);
    }

    public function store(Request $request): void
    {
        //        dd($request);
        //        $request->validate([
        //            "kanji_id" => "required|string",
        //            "user_id" => "required|string",
        //            "tiempo" => "required|numeric",
        //            "betaA" => "required|numeric",
        //            "betaB" => "required|numeric",
        //            "respuesta" => "required|boolean",
        //            "aciertos" => "required|numeric",
        //            "intentos" => "required|numeric",
        //        ]);
        //
        //        Estudio::create([...$request->all(), "fecha" => Carbon::now()]);
    }

    private function getStudyKanjis(): Collection
    {
        //Obtenemos información del usuario
        $userId = auth()->user()->id;
        $userIndex = "indice_" . auth()->user()->indice;

        // Obtenemos los kanjis a estudiar
        $kanjis = Kanji::whereNotIn("id", function ($query) use ($userId) {
            $query
                ->select("kanji_id")
                ->from("estudios")
                ->where("user_id", "=", $userId);
        })
            ->orderBy($userIndex)
            ->limit(10)
            ->get();

        //Les añadimos sus radicales
        $kanjis->load("radicales");

        return $kanjis;
    }
}
