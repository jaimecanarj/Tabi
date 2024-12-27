<?php

namespace App\Http\Controllers;

use App\Models\Kanji;
use Request;
use Inertia\Inertia;
use Inertia\Response;

class KanjiController extends Controller
{
    public function index(): Response
    {
        //Ordenamos los kanjis por su índice si está logueado
        $index = "heisig_index";
        if (auth()->check()) {
            $index = auth()->user()->index . "_index";
        }

        $strokesFilter = Request::input("strokes");
        $gradeFilter = Request::input("grade");

        //Filtro de texto
        $data = Kanji::query()->when(Request::input("search"), function (
            $query,
            $search
        ) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where("meaning", "like", "%$search%")
                    ->orWhere("literal", "=", $search);
            });
        });

        //Datos filtro de trazos
        $strokes = (clone $data)
            ->when($gradeFilter, function ($query, $grade) {
                $query->where("grade", "=", $grade);
            })
            ->get()
            ->pluck("strokes")
            ->unique()
            ->sort()
            ->values();

        if ($strokesFilter && !$strokes->contains($strokesFilter)) {
            $strokes->push($strokesFilter);
            $strokes = $strokes->unique()->sort()->values();
        }

        //Datos filtro de grados
        $grades = (clone $data)
            ->when($strokesFilter, function ($query, $strokes) {
                $query->where("strokes", "=", $strokes);
            })
            ->get()
            ->pluck("grade")
            ->unique()
            ->sort()
            ->values();

        if ($gradeFilter && !$grades->contains($gradeFilter)) {
            $grades->push($gradeFilter);
            $grades = $grades->unique()->sort()->values();
        }

        //Paginación
        $kanjis = $data
            //Filtro de trazos
            ->when($strokesFilter, function ($query, $strokes) {
                $query->where("strokes", "=", $strokes);
            })
            //Filtro de grado
            ->when($gradeFilter, function ($query, $grade) {
                $query->where("grade", "=", $grade);
            })
            //Ordenación
            ->orderBy(
                Request::input("sortCategory") ?? $index,
                Request::input("sortOrder") ?? "asc"
            )
            ->paginate(12);

        return Inertia::render("Kanjis", [
            "response" => $kanjis,
            "filters" => Request::only([
                "search",
                "strokes",
                "grade",
                "sortCategory",
                "sortOrder",
            ]),
            "strokes" => $strokes,
            "grades" => $grades,
        ]);
    }

    public function show($id): Response
    {
        $userId = auth()->user()?->id;

        $kanji = Kanji::find($id);
        $readings = Kanji::find($id)->readings;
        $meanings = Kanji::find($id)->meanings;
        $radicals = Kanji::find($id)->radicals;
        $similarKanjis = Kanji::find($id)->similarKanjis;

        if (isset($userId)) {
            $kanji->load([
                "studies" => function ($query) use ($userId) {
                    $query
                        ->where("user_id", "=", $userId)
                        ->orderBy("date", "desc");
                },
            ]);
        }

        return Inertia::render("Kanji", [
            "kanji" => $kanji,
            "readings" => $readings,
            "meanings" => $meanings,
            "radicals" => $radicals,
            "similarKanjis" => $similarKanjis,
        ]);
    }
}
