<?php

namespace App\Http\Controllers;

use App\Models\Kanji;
use Illuminate\Http\Request;
use Request as QueryRequest;
use Inertia\Inertia;

class KanjiController extends Controller
{
    public function index()
    {
        //Ordenamos los kanjis por su índice si está logueado
        $index = "indice_escolar";
        if (auth()->check()) {
            $index = "indice_" . auth()->user()->indice;
        }

        //Filtro de texto
        $data = Kanji::query()->when(QueryRequest::input("search"), function (
            $query,
            $search
        ) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where("significado", "like", "%{$search}%")
                    ->orWhere("literal", "=", $search);
            });
        });

        //Datos filtro de trazos
        $strokes = (clone $data)
            ->when(QueryRequest::input("grade"), function ($query, $grade) {
                $query->where("grado", "=", $grade);
            })
            ->get()
            ->pluck("trazos")
            ->unique()
            ->sort()
            ->values();

        //Datos filtro de grados
        $grades = (clone $data)
            ->when(QueryRequest::input("strokes"), function ($query, $strokes) {
                $query->where("trazos", "=", $strokes);
            })
            ->get()
            ->pluck("grado")
            ->unique()
            ->sort()
            ->values();

        //Paginación
        $kanjis = $data
            //Filtro de trazos
            ->when(QueryRequest::input("strokes"), function ($query, $strokes) {
                $query->where("trazos", "=", $strokes);
            })
            //Filtro de grado
            ->when(QueryRequest::input("grade"), function ($query, $grade) {
                $query->where("grado", "=", $grade);
            })
            //Ordenación
            ->orderBy(
                QueryRequest::input("sortCategory") ?? $index,
                QueryRequest::input("sortOrder") ?? "asc"
            )
            ->paginate(12);

        return Inertia::render("Kanjis", [
            "response" => $kanjis,
            "filters" => QueryRequest::only([
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

    public function show($id)
    {
        $kanji = Kanji::find($id);
        $lecturas = Kanji::find($id)->lecturas;
        $significados = Kanji::find($id)->significados;
        $radicales = Kanji::find($id)->radicales;
        $similares = Kanji::find($id)->similares;

        return Inertia::render("Kanji", [
            "kanji" => $kanji,
            "lecturas" => $lecturas,
            "significados" => $significados,
            "radicales" => $radicales,
            "similares" => $similares,
        ]);
    }

    public function search(Request $request)
    {
        $literal = $request->kanji;
        $id = Kanji::where("literal", $literal)->first()->id;
        return redirect()->route("kanji", ["id" => $id]);
    }
}
