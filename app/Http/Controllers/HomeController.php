<?php

namespace App\Http\Controllers;

use App\Models\Kanji;
use App\Models\Radical;
use Illuminate\Http\Request;

class HomeController extends Controller
{
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
