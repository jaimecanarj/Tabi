<?php

namespace App\Http\Controllers;

use App\Models\Historia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
        $request->validate([
            "historia" => "required|string",
            "user_id" => "required|exists:users,id",
            "kanji_id" => "required|exists:kanjis,id",
        ]);

        $historia = Historia::updateOrCreate(
            ["id" => $request->id],
            $request->all()
        );

        return Redirect::back()->with([
            "data" => "Something you want to pass to front-end",
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            "id" => "required|exists:historias",
        ]);

        Historia::where("id", $request->id)->delete();
    }
}
