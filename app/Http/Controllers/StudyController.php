<?php

namespace App\Http\Controllers;

use App\Models\Study;
use App\Models\Kanji;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Database\Eloquent\Collection;

class StudyController extends Controller
{
    public function show(): Response
    {
        $kanjis = StudyController::getStudyKanjis();

        return Inertia::render("Study", [
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
            $kanjis = StudyController::getStudyKanjis();

            return Inertia::render("Review", [
                "kanjis" => $kanjis,
            ]);
        }

        //De repasar
        $userId = auth()->user()->id;

        $kanjis = Kanji::whereIn("id", function ($query) use ($userId) {
            $query
                ->select("kanji_id")
                ->from("studies")
                ->where("user_id", "=", $userId);
        })->get();

        //Obtener último estudio de cada kanji
        $kanjis->load([
            "study" => function ($query) use ($userId) {
                $query->where("user_id", "=", $userId)->orderBy("date", "desc");
            },
            "radicals",
        ]);

        return Inertia::render("Review", [
            "kanjis" => $kanjis,
        ]);
    }

    public function store(Request $request): void
    {
        foreach ($request->studys as $study) {
            $validator = Validator::make($study, [
                "kanji_id" => "required|numeric",
                "user_id" => "required|numeric",
                "time" => "required|numeric",
                "betaA" => "required|numeric",
                "betaB" => "required|numeric",
                "answer" => "required|boolean",
                "successes" => "required|numeric",
                "attempts" => "required|numeric",
            ]);

            if ($validator->fails()) {
                dd($validator->errors());
            }

            Study::create([...$study, "date" => Carbon::now()]);
        }
    }

    private function getStudyKanjis(): Collection
    {
        //Obtenemos información del usuario
        $userId = auth()->user()->id;
        $userIndex = auth()->user()->index . "_index";

        // Obtenemos los kanjis a estudiar
        $kanjis = Kanji::whereNotIn("id", function ($query) use ($userId) {
            $query
                ->select("kanji_id")
                ->from("studies")
                ->where("user_id", "=", $userId);
        })
            ->orderBy($userIndex)
            ->limit(10)
            ->get();

        //Les añadimos sus radicales
        $kanjis->load("radicals");

        return $kanjis;
    }
}
