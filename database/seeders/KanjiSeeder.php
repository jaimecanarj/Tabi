<?php

namespace Database\Seeders;

use App\Models\Kanji;
use App\Models\Lectura;
use App\Models\Significado;
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
        $json = File::get("database/json/kanjis.json");
        $kanjis = collect(json_decode($json, true));
        $kanjis->each(
            callback: function ($kanji) {
                //Añadir kanjis
                $newKanji = Kanji::create([
                    "literal" => $kanji["literal"],
                    "grado" => $kanji["grado"],
                    "trazos" => $kanji["trazos"],
                    "frecuencia" => $kanji["frecuencia"] ?? null,
                ]);

                //Añadir lecturas
                foreach ($kanji["lecturas"] as $lectura) {
                    Lectura::insert([
                        "kanji_id" => $newKanji->id,
                        "lectura" => $lectura["texto"],
                        "tipo" => $lectura["tipo"],
                    ]);
                }

                //Añadir significados
                foreach ($kanji["significados"] as $significado) {
                    Significado::insert([
                        "kanji_id" => $newKanji->id,
                        "significado" => $significado["texto"],
                    ]);
                }
            }
        );
    }
}
