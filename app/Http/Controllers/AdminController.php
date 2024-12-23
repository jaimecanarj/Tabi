<?php

namespace App\Http\Controllers;

use App\Models\Kanji;
use App\Models\Radical;
use App\Models\User;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        $kanjiCount = Kanji::all()->count();
        $radicalCount = Radical::all()->count();
        $userCount = User::all()->count();

        return Inertia::render("Admin/Index", [
            "kanjis" => $kanjiCount,
            "radicals" => $radicalCount,
            "users" => $userCount,
        ]);
    }

    public function kanjiIndex()
    {
        return Kanji::all();
    }

    public function kanjiDestroy($id)
    {
        Kanji::destroy($id);
    }

    public function radicalIndex()
    {
        return Radical::all();
    }

    public function radicalDestroy($id)
    {
        Radical::destroy($id);
    }

    public function userIndex()
    {
        return User::all();
    }

    public function userDestroy($id)
    {
        User::destroy($id);
    }
}
