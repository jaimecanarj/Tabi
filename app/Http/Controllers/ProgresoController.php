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
            $startDate = Request::input("start");
            $endDate = Carbon::parse(Request::input("end"))->endOfDay();
            $kanjis->load([
                "estudios" => function ($query) use (
                    $userId,
                    $startDate,
                    $endDate
                ) {
                    $query
                        ->whereBetween("fecha", [$startDate, $endDate])
                        ->where("user_id", "=", $userId)
                        ->orderBy("fecha", "desc");
                },
            ]);
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

        //Calcular numero de kanjis estudiados
        $kanjisStudiedNumber = Estudio::where("user_id", "=", $userId)
            ->whereBetween("fecha", [$startDate, $endDate])
            ->whereRaw(
                "id IN ( SELECT MAX(id) FROM estudios
                    WHERE user_id = $userId GROUP BY kanji_id )"
            )
            ->orderBy("fecha", "desc")
            ->count();

        //Calcular numero de estudios del usuario
        $userStudySessions = Estudio::where("user_id", "=", $userId)
            ->whereBetween("fecha", [$startDate, $endDate])
            ->count();

        //Calcular numero de aciertos
        $userCorrectAnswers = Estudio::where("user_id", "=", $userId)
            ->whereBetween("fecha", [$startDate, $endDate])
            ->where("respuesta", "=", true)
            ->count();

        //Si el usuario no ha estudiado todavía
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
            "details" => [
                "kanjisStudiedNumber" => $kanjisStudiedNumber,
                "userStudySessions" => $userStudySessions,
                "userCorrectAnswers" => $userCorrectAnswers,
            ],
        ]);
    }
}
