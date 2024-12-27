<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KanjiController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\RadicalController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\StudyController;

// Rutas básicas
Route::inertia("/", "Welcome");
Route::get("/inicio", [HomeController::class, "index"])->name("home");
Route::inertia("/about", "About");
Route::get("/search/{query}", [HomeController::class, "search"]);
Route::get("/usuarios/{id}", [RegisteredUserController::class, "show"]);

// Kanjis
Route::get("/kanjis", [KanjiController::class, "index"]);
Route::get("/kanjis/{id}", [KanjiController::class, "show"])->name("kanji");

// Radicales
Route::get("/radicales", [RadicalController::class, "index"]);
Route::get("/radicales/{id}", [RadicalController::class, "show"]);

// Historias
Route::get("/story/{user_id}/{kanji_id}", [StoryController::class, "show"]);
Route::post("/story", [StoryController::class, "store"]);
Route::delete("/story", [StoryController::class, "destroy"]);

// Estudios
Route::middleware("auth")->group(function () {
    Route::get("/estudiar", [StudyController::class, "show"]);
    Route::get("/repasar", [StudyController::class, "review"]);
    Route::post("/review", [StudyController::class, "store"]);
    Route::get("/progreso", [ProgressController::class, "index"]);
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
