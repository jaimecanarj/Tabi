<?php

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
Route::get("/kanjis/{id}", [KanjiController::class, "show"]);

// Radicales
Route::get("/radicales", [RadicalController::class, "index"]);
Route::get("/radicales/{id}", [RadicalController::class, "show"]);

// Rutas legacy
Route::middleware("auth")->group(function () {
    Route::get("/profile", [ProfileController::class, "edit"])->name(
        "profile.edit"
    );
    Route::patch("/profile", [ProfileController::class, "update"])->name(
        "profile.update"
    );
    Route::delete("/profile", [ProfileController::class, "destroy"])->name(
        "profile.destroy"
    );
});

require __DIR__ . "/auth.php";
