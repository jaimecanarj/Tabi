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
        $index = "indice_escolar";
        if (auth()->check()) {
            $index = "indice_" . auth()->user()->indice;
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
                    ->where("significado", "like", "%$search%")
                    ->orWhere("literal", "=", $search);
            });
        });

        //Datos filtro de trazos
        $strokes = (clone $data)
            ->when($gradeFilter, function ($query, $grade) {
                $query->where("grado", "=", $grade);
            })
            ->get()
            ->pluck("trazos")
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
                $query->where("trazos", "=", $strokes);
            })
            ->get()
            ->pluck("grado")
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
                $query->where("trazos", "=", $strokes);
            })
            //Filtro de grado
            ->when($gradeFilter, function ($query, $grade) {
                $query->where("grado", "=", $grade);
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
            "trazos" => $strokes,
            "grados" => $grades,
        ]);
    }

    public function show($id): Response
    {
        $userId = auth()->user()?->id;

        $kanji = Kanji::find($id);
        $lecturas = Kanji::find($id)->lecturas;
        $significados = Kanji::find($id)->significados;
        $radicales = Kanji::find($id)->radicales;
        $similares = Kanji::find($id)->similares;

        if (isset($userId)) {
            $kanji->load([
                "estudios" => function ($query) use ($userId) {
                    $query
                        ->where("user_id", "=", $userId)
                        ->orderBy("fecha", "desc");
                },
            ]);
        }

        return Inertia::render("Kanji", [
            "kanji" => $kanji,
            "lecturas" => $lecturas,
            "significados" => $significados,
            "radicales" => $radicales,
            "similares" => $similares,
        ]);
    }
}
