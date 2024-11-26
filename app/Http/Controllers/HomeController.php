<?php

namespace App\Http\Controllers;

use App\Models\Estudio;
use App\Models\Kanji;
use App\Models\Radical;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $userId = auth()->user()?->id;

        if (isset($userId)) {
            $estudios = Estudio::where("user_id", "=", $userId)
                ->orderBy("fecha", "desc")
                ->get();

            $estudios->load(["kanji"]);
        } else {
            $estudios = [];
        }

        return Inertia::render("Home", ["estudios" => $estudios]);
    }
    public function search($query)
    {
        $kanjis = Kanji::where("significado", "LIKE", "%$query%")
            ->orWhere("literal", "=", "%$query%")
            ->get();
        $radicales = Radical::where("significado", "LIKE", "%$query%")
            ->orWhere("literal", "=", "%$query%")
            ->get();

        return ["kanjis" => $kanjis, "radicales" => $radicales];
    }
}
