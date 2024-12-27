<?php

namespace App\Http\Controllers;

use App\Models\Study;
use App\Models\Kanji;
use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;
use Request;

class ProgressController extends Controller
{
    public function index(): Response
    {
        //Obtenemos información del usuario
        $userId = auth()->user()->id;
        $userIndex = auth()->user()->index . "_index";

        //Obtenemos los kanjis ordenados por el índice del usuario
        $kanjis = Kanji::orderBy($userIndex)->get();

        //Obtenemos estudios basados en fechas
        if (Request::input("start") && Request::input("end")) {
            $startDate = Request::input("start");
            $endDate = Carbon::parse(Request::input("end"))->endOfDay();
            $kanjis->load([
                "studies" => function ($query) use (
                    $userId,
                    $startDate,
                    $endDate
                ) {
                    $query
                        ->whereBetween("date", [$startDate, $endDate])
                        ->where("user_id", "=", $userId)
                        ->orderBy("date", "desc");
                },
            ]);
        }
        //Obtenemos todos si no tiene fechas
        else {
            $kanjis->load([
                "studies" => function ($query) use ($userId) {
                    $query
                        ->where("user_id", "=", $userId)
                        ->orderBy("date", "desc");
                },
            ]);
            //Obtenemos primera y última fecha de estudio
            $startDate = Study::where("user_id", $userId)
                ->oldest("date")
                ->first()?->date;
            $endDate = Study::where("user_id", $userId)->latest("date")->first()
                ?->date;
        }

        //Calcular numero de kanjis estudiados
        $kanjisStudiedNumber = Study::where("user_id", "=", $userId)
            ->whereBetween("date", [$startDate, $endDate])
            ->whereRaw(
                "id IN (
            SELECT MAX(id)
            FROM studies
            WHERE user_id = ? AND date BETWEEN ? AND ?
            GROUP BY kanji_id
        )",
                [$userId, $startDate, $endDate]
            )
            ->orderBy("date", "desc")
            ->count();

        //Calcular numero de estudios del usuario
        $userStudySessions = Study::where("user_id", "=", $userId)
            ->whereBetween("date", [$startDate, $endDate])
            ->count();

        //Calcular numero de aciertos
        $userCorrectAnswers = Study::where("user_id", "=", $userId)
            ->whereBetween("date", [$startDate, $endDate])
            ->where("answer", "=", true)
            ->count();

        //Si el usuario no ha estudiado todavía
        if (is_null($startDate) && is_null($endDate)) {
            $startDate = Carbon::now();
            $endDate = Carbon::now();
        }

        return Inertia::render("Progress", [
            "kanjis" => $kanjis,
            "dates" => [
                "start" => $startDate,
                "end" => $endDate,
            ],
            "details" => [
                "kanjisStudiedNumber" => $kanjisStudiedNumber,
                "userStudySessions" => $userStudySessions,
                "userCorrectAnswers" => $userCorrectAnswers,
            ],
        ]);
    }
}
