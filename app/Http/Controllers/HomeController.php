<?php

namespace App\Http\Controllers;

use App\Models\Estudio;
use App\Models\Kanji;
use App\Models\Radical;
use Carbon\Carbon;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $userId = auth()->user()?->id;

        if (isset($userId)) {
            //Obtener último estudio de cada kanji del usuario
            $studys = Estudio::where("user_id", "=", $userId)
                ->whereRaw(
                    "id IN ( SELECT MAX(id) FROM estudios
                    WHERE user_id = $userId GROUP BY kanji_id )"
                )
                ->orderBy("fecha", "desc")
                ->get();

            $studysWeek = $studys
                ->filter(function ($study) {
                    $date = Carbon::parse($study["fecha"])->addHours(
                        $study["tiempo"]
                    );

                    return $date->isBefore(Carbon::now()->addDays(7));
                })
                ->values();

            //Calcular kanjis disponibles para repasar
            $kanjisToReview = count(
                $studysWeek->filter(function ($study) {
                    $date = Carbon::parse($study["fecha"])->addHours(
                        $study["tiempo"]
                    );

                    return $date->isBefore(Carbon::now());
                })
            );

            //Calcular numero de kanjis estudiados
            $kanjisStudiedNumber = $studys->count();

            //Calcular numero de estudios del usuario
            $userStudySessions = Estudio::where(
                "user_id",
                "=",
                $userId
            )->count();

            //Calcular numero de aciertos
            $userCorrectAnswers = Estudio::where("user_id", "=", $userId)
                ->where("respuesta", "=", true)
                ->count();

            //Obtener últimos kanjis fallados
            $lastWrongKanjis = Estudio::where("user_id", "=", $userId)
                ->where("respuesta", "=", false)
                ->distinct()
                ->orderBy("fecha", "desc")
                ->limit(28)
                ->get();
            $lastWrongKanjis->load(["kanji"]);

            //Obtener últimos kanjis repasados
            $lastReviewedKanjis = Estudio::where("user_id", "=", $userId)
                ->distinct()
                ->orderBy("fecha", "desc")
                ->limit(28)
                ->get();
            $lastReviewedKanjis->load(["kanji"]);

            //Calcular kanjis estudiados hoy
            $studiedToday = Estudio::where("user_id", "=", $userId)
                ->whereDate("fecha", "=", Carbon::today())
                ->where("intentos", "=", 1)
                ->count();

            //Calcular kanjis repasados hoy
            $reviewedToday = Estudio::where("user_id", "=", $userId)
                ->whereDate("fecha", "=", Carbon::today())
                ->where("intentos", ">", 1)
                ->count();

            $data = [
                "studys" => $studysWeek,
                "kanjisToReview" => $kanjisToReview,
                "kanjisStudiedNumber" => $kanjisStudiedNumber,
                "userStudySessions" => $userStudySessions,
                "userCorrectAnswers" => $userCorrectAnswers,
                "lastWrongKanjis" => $lastWrongKanjis,
                "lastReviewedKanjis" => $lastReviewedKanjis,
                "studiedToday" => $studiedToday,
                "reviewedToday" => $reviewedToday,
            ];
        } else {
            $data = [];
        }

        return Inertia::render("Home", ["data" => $data]);
    }
    public function search($query)
    {
        $kanjis = Kanji::where("significado", "LIKE", "%$query%")
            ->orWhere("literal", "=", "%$query%")
            ->get();
        $radicales = Radical::where("significado", "LIKE", "%$query%")
            ->orWhere("literal", "=", "%$query%")
            ->get();

        return ["kanjis" => $kanjis, "radicales" => $radicales];
    }
}
