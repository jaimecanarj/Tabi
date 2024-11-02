<?php

namespace App\Http\Controllers;

use App\Models\Historia;
use Illuminate\Http\Request;

class HistoriaController extends Controller
{
    public function show($user_id, $kanji_id)
    {
        return Historia::where("user_id", $user_id)
            ->where("kanji_id", $kanji_id)
            ->first();
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "historia" => "required|string",
            "user_id" => "required|exists:users,id",
            "kanji_id" => "required|exists:kanjis,id",
        ]);

        Historia::updateOrCreate(["id" => $request->id], $request->all());
    }
}
