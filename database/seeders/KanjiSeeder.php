<?php

namespace Database\Seeders;

use App\Models\Kanji;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class KanjiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/data.json");
        $kanjis = collect(json_decode($json, true));
        $kanjis->each(
            callback: function ($kanji) {
                Kanji::create([
                    "literal" => $kanji["literal"],
                    "grado" => $kanji["grado"],
                    "trazos" => $kanji["trazos"],
                    "frecuencia" => $kanji["frecuencia"] ?? null,
                ]);
            }
        );
    }
}
