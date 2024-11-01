<?php

namespace App\Http\Controllers;

use App\Models\Radical;
use Inertia\Inertia;

class RadicalController extends Controller
{
    public function index()
    {
        $radicales = Radical::all();
        return Inertia::render("Radicales", ["radicales" => $radicales]);
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
