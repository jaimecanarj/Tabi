<?php

namespace App\Http\Controllers;

use App\Models\Study;
use App\Models\Kanji;
use App\Models\Radical;
use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        $userId = auth()->user()?->id;

        if (isset($userId)) {
            //Obtener último estudio de cada kanji del usuario
            $studys = Study::where("user_id", "=", $userId)
                ->whereRaw(
                    "id IN ( SELECT MAX(id) FROM studies
                    WHERE user_id = $userId GROUP BY kanji_id )"
                )
                ->orderBy("date", "desc")
                ->get();

            $studysWeek = $studys
                ->filter(function ($study) {
                    $date = Carbon::parse($study["date"])->addHours(
                        $study["time"]
                    );

                    return $date->isBefore(Carbon::now()->addDays(7));
                })
                ->values();

            //Calcular kanjis disponibles para repasar
            $kanjisToReview = count(
                $studysWeek->filter(function ($study) {
                    $date = Carbon::parse($study["date"])->addHours(
                        $study["time"]
                    );

                    return $date->isBefore(Carbon::now());
                })
            );

            //Calcular numero de kanjis estudiados
            $kanjisStudiedNumber = $studys->count();

            //Calcular numero de estudios del usuario
            $userStudySessions = Study::where("user_id", "=", $userId)->count();

            //Calcular numero de aciertos
            $userCorrectAnswers = Study::where("user_id", "=", $userId)
                ->where("answer", "=", true)
                ->count();

            //Obtener últimos kanjis fallados
            $lastWrongKanjis = Study::where("user_id", "=", $userId)
                ->where("answer", "=", false)
                ->distinct()
                ->orderBy("date", "desc")
                ->limit(28)
                ->get();
            $lastWrongKanjis->load(["kanji"]);

            //Obtener últimos kanjis repasados
            $lastReviewedKanjis = Study::where("user_id", "=", $userId)
                ->distinct()
                ->orderBy("date", "desc")
                ->limit(28)
                ->get();
            $lastReviewedKanjis->load(["kanji"]);

            //Calcular kanjis estudiados hoy
            $studiedToday = Study::where("user_id", "=", $userId)
                ->whereDate("date", "=", Carbon::today())
                ->where("attempts", "=", 1)
                ->count();

            //Calcular kanjis repasados hoy
            $reviewedToday = Study::where("user_id", "=", $userId)
                ->whereDate("date", "=", Carbon::today())
                ->where("attempts", ">", 1)
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
        $kanjis = Kanji::where("meaning", "LIKE", "%$query%")
            ->orWhere("literal", "=", "%$query%")
            ->get();
        $radicales = Radical::where("meaning", "LIKE", "%$query%")
            ->orWhere("literal", "=", "%$query%")
            ->get();

        return ["kanjis" => $kanjis, "radicals" => $radicales];
    }
}
