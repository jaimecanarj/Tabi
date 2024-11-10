<?php

namespace App\Http\Controllers;

use App\Models\Radical;
use Inertia\Inertia;
use Request;

class RadicalController extends Controller
{
    public function index()
    {
        $radicales = Radical::query()
            //Filtro de trazos
            ->when(Request::input("strokes"), function ($query, $strokes) {
                $query->where("trazos", "=", $strokes);
            })
            //Filtro de buscador
            ->when(Request::input("search"), function ($query, $search) {
                $query
                    ->where("significado", "like", "%{$search}%")
                    ->orWhere("literal", "=", $search);
            })
            //Ordenación
            ->orderBy(
                Request::input("sortCategory") ?? "trazos",
                Request::input("sortOrder") ?? "asc"
            )
            ->paginate(12);

        return Inertia::render("Radicales", [
            "response" => $radicales,
            "filters" => Request::only(["strokes"]),
        ]);
    }

    public function show($id)
    {
        $radical = Radical::find($id);
        $kanjis = Radical::find($id)->kanjis;

        return Inertia::render("Radical", [
            "radical" => $radical,
            "kanjis" => $kanjis,
        ]);
    }
}
