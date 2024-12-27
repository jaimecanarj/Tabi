<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function show($user_id, $kanji_id): ?Story
    {
        return Story::where("user_id", $user_id)
            ->where("kanji_id", $kanji_id)
            ->first();
    }

    public function store(Request $request): void
    {
        $request->validate([
            "story" => "required|string",
            "user_id" => "required|exists:users,id",
            "kanji_id" => "required|exists:kanjis,id",
        ]);

        Story::updateOrCreate(["id" => $request->id], $request->all());
    }

    public function destroy(Request $request): void
    {
        $request->validate([
            "id" => "required|exists:stories",
        ]);

        Story::where("id", $request->id)->delete();
    }
}
