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
        return Inertia::render("Radicals", [
            "data" => Inertia::defer(fn() => $this->indexDeferredProps()),
            "filters" => Request::only([
                "search",
                "strokes",
                "sortCategory",
                "sortOrder",
                "page",
            ]),
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

    private function indexDeferredProps()
    {
        $strokesFilter = Request::input("strokes");

        //Filtro de buscador
        $data = Radical::query()
            ->withCount(["kanjis as kanjisCount"])
            ->when(Request::input("search"), function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where("meaning", "like", "%$search%")
                        ->orWhere("literal", "=", $search);
                });
            });

        //Datos filtro de trazos
        $strokes = $data->get()->pluck("strokes")->unique()->sort()->values();

        //Añadir trazos seleccionado si no está entre los posibles filtros
        if ($strokesFilter && !$strokes->contains($strokesFilter)) {
            $strokes->push($strokesFilter)->sort()->values();
        }

        //Paginación
        $radicals = $data
            //Filtro de trazos
            ->when($strokesFilter, function ($query, $strokes) {
                $query->where("strokes", "=", $strokes);
            })
            //Ordenación
            ->orderBy(
                Request::input("sortCategory") ?? "strokes",
                Request::input("sortOrder") ?? "asc"
            )
            ->paginate(12);

        return [
            "response" => $radicals,
            "strokes" => $strokes,
        ];
    }
}
