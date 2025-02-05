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
        return Inertia::render("Kanjis", [
            "data" => Inertia::defer(fn() => $this->indexDeferredProps()),
            "filters" => Request::only([
                "search",
                "strokes",
                "grade",
                "sortCategory",
                "sortOrder",
                "page",
            ]),
        ]);
    }

    public function show($id): Response
    {
        //        $userId = auth()->user()?->id;

        //        $kanji = Kanji::find($id);
        //        $readings = Kanji::find($id)->readings;
        //        $meanings = Kanji::find($id)->meanings;
        //        $radicals = Kanji::find($id)->radicals;
        //        $similarKanjis = Kanji::find($id)->similarKanjis;

        //        if (isset($userId)) {
        //            $kanji->load([
        //                "studies" => function ($query) use ($userId) {
        //                    $query
        //                        ->where("user_id", "=", $userId)
        //                        ->orderBy("date", "desc");
        //                },
        //            ]);
        //        }

        return Inertia::render("Kanji", [
            "kanji" => Inertia::defer(fn() => $this->showDeferredKanji($id)),
            "readings" => Inertia::defer(fn() => Kanji::find($id)->readings),
            "meanings" => Inertia::defer(fn() => Kanji::find($id)->meanings),
            "radicals" => Inertia::defer(fn() => Kanji::find($id)->radicals),
            "similarKanjis" => Inertia::defer(
                fn() => Kanji::find($id)->similarKanjis
            ),
        ]);
    }

    private function indexDeferredProps(): array
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

        //Añadir trazos seleccionado si no está entre los posibles filtros
        if ($strokesFilter && !$strokes->contains($strokesFilter)) {
            $strokes->push($strokesFilter)->sort()->values();
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

        //Añadir grado seleccionado si no está entre los posibles filtros
        if ($gradeFilter && !$grades->contains($gradeFilter)) {
            $grades->push($gradeFilter)->sort()->values();
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

        return [
            "response" => $kanjis,
            "strokes" => $strokes,
            "grades" => $grades,
        ];
    }

    private function showDeferredKanji($id)
    {
        $userId = auth()->user()?->id;

        $kanji = Kanji::find($id);

        if (isset($userId)) {
            $kanji->load([
                "studies" => function ($query) use ($userId) {
                    $query
                        ->where("user_id", "=", $userId)
                        ->orderBy("date", "desc");
                },
            ]);
        }

        return $kanji;
    }
}
