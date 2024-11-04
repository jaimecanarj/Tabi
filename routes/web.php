<?php

use App\Http\Controllers\HistoriaController;
use App\Http\Controllers\KanjiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RadicalController;
use Illuminate\Support\Facades\Route;

// Rutas temporales
Route::inertia("/", "Welcome");
Route::inertia("/home", "Home")->name("home");
Route::inertia("/test", "Test");

// Kanjis
Route::get("/kanjis", [KanjiController::class, "index"]);
Route::get("/kanjis/{id}", [KanjiController::class, "show"])->name("kanji");
Route::get("/search/{literal}", [KanjiController::class, "search"]);

// Radicales
Route::get("/radicales", [RadicalController::class, "index"]);
Route::get("/radicales/{id}", [RadicalController::class, "show"]);

// Historias
Route::get("/historia/{user_id}/{kanji_id}", [
    HistoriaController::class,
    "show",
]);
Route::post("/historia", [HistoriaController::class, "store"]);
Route::delete("/historia", [HistoriaController::class, "destroy"]);

require __DIR__ . "/auth.php";
