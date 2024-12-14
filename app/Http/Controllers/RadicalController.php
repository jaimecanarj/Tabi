<?php

namespace App\Http\Controllers;

use App\Models\Radical;
use Inertia\Inertia;
use Request;
use Inertia\Response;

class RadicalController extends Controller
{
    public function index(): Response
    {
        $strokesFilter = Request::input("strokes");

        //Filtro de buscador
        $data = Radical::query()
            ->withCount("kanjis")
            ->when(Request::input("search"), function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where("significado", "like", "%$search%")
                        ->orWhere("literal", "=", $search);
                });
            });

        //Datos filtro de trazos
        $strokes = $data->get()->pluck("trazos")->unique()->sort()->values();

        if ($strokesFilter && !$strokes->contains($strokesFilter)) {
            $strokes->push($strokesFilter);
            $strokes = $strokes->unique()->sort()->values();
        }

        //Paginación
        $radicales = $data
            //Filtro de trazos
            ->when($strokesFilter, function ($query, $strokes) {
                $query->where("trazos", "=", $strokes);
            })
            //Ordenación
            ->orderBy(
                Request::input("sortCategory") ?? "trazos",
                Request::input("sortOrder") ?? "asc"
            )
            ->paginate(12);

        return Inertia::render("Radicales", [
            "response" => $radicales,
            "filters" => Request::only([
                "search",
                "strokes",
                "sortCategory",
                "sortOrder",
            ]),
            "trazos" => $strokes,
        ]);
    }

    public function show($id): Response
    {
        $radical = Radical::find($id);
        $kanjis = Radical::find($id)->kanjis;

        return Inertia::render("Radical", [
            "radical" => $radical,
            "kanjis" => $kanjis,
        ]);
    }
}
