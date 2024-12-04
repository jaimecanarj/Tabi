<?php

namespace App\Http\Controllers;

use App\Models\Estudio;
use App\Models\Kanji;
use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;
use Request;

class ProgresoController extends Controller
{
    public function index(): Response
    {
        //Obtenemos información del usuario
        $userId = auth()->user()->id;
        $userIndex = "indice_" . auth()->user()->indice;

        //Obtenemos los kanjis ordenados por el índice del usuario
        $kanjis = Kanji::orderBy($userIndex)->get();

        //Obtenemos estudios basados en fechas
        if (Request::input("start") && Request::input("end")) {
            $start = Request::input("start");
            $end = Request::input("end");
            $kanjis->load([
                "estudios" => function ($query) use ($userId, $start, $end) {
                    $query
                        ->whereBetween("fecha", [$start, $end])
                        ->where("user_id", "=", $userId)
                        ->orderBy("fecha", "desc");
                },
            ]);
            $startDate = Request::input("start");
            $endDate = Request::input("end");
        }
        //Obtenemos todos si no tiene fechas
        else {
            $kanjis->load([
                "estudios" => function ($query) use ($userId) {
                    $query
                        ->where("user_id", "=", $userId)
                        ->orderBy("fecha", "desc");
                },
            ]);
            //Obtenemos primera y última fecha de estudio
            $startDate = Estudio::where("user_id", $userId)
                ->oldest("fecha")
                ->first()?->fecha;
            $endDate = Estudio::where("user_id", $userId)
                ->latest("fecha")
                ->first()?->fecha;
        }

        if (is_null($startDate) && is_null($endDate)) {
            $startDate = Carbon::now();
            $endDate = Carbon::now();
        }

        return Inertia::render("Progreso", [
            "kanjis" => $kanjis,
            "fechas" => [
                "inicio" => $startDate,
                "fin" => $endDate,
            ],
        ]);
    }
}
