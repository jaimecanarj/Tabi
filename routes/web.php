<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EstudioController;
use App\Http\Controllers\HistoriaController;
use App\Http\Controllers\KanjiController;
use App\Http\Controllers\ProgresoController;
use App\Http\Controllers\RadicalController;
use App\Http\Controllers\HomeController;

// Rutas básicas
Route::inertia("/", "Welcome");
Route::get("/inicio", [HomeController::class, "index"])->name("home");
Route::inertia("/about", "About");
Route::get("/search/{query}", [HomeController::class, "search"]);
Route::get("/usuarios/{id}", [RegisteredUserController::class, "show"]);

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

// Estudios
Route::middleware("auth")->group(function () {
    Route::get("/estudiar", [EstudioController::class, "show"]);
    Route::get("/repasar", [EstudioController::class, "review"]);
    Route::post("/repasar", [EstudioController::class, "store"]);
    Route::get("/progreso", [ProgresoController::class, "index"]);
});

// Admin
Route::middleware(IsAdmin::class)->group(function () {
    Route::get("/admin", [AdminController::class, "index"]);
    Route::get("/admin/kanjis", [AdminController::class, "kanjiIndex"]);
    Route::delete("/admin/kanjis/destroy/{id}", [
        AdminController::class,
        "kanjiDestroy",
    ]);
    Route::get("/admin/radicals", [AdminController::class, "radicalIndex"]);
    Route::delete("/admin/radicales/destroy/{id}", [
        AdminController::class,
        "radicalDestroy",
    ]);
    Route::get("/admin/users", [AdminController::class, "userIndex"]);
    Route::delete("/admin/users/destroy/{id}", [
        AdminController::class,
        "userDestroy",
    ]);
});

require_once __DIR__ . "/auth.php";
