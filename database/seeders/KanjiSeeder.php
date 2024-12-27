<?php

namespace Database\Seeders;

use App\Models\Kanji;
use App\Models\Reading;
use App\Models\Meaning;
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
                    "grade" => $kanji["grade"],
                    "strokes" => $kanji["strokes"],
                    "meaning" => $kanji["meanings"][0],
                    "frequency" => $kanji["frequency"] ?? null,
                    "heisig_index" => $kanji["HeisigIndex"],
                    "wanikani_index" => $kanji["WaniKaniIndex"],
                ]);

                //Añadir lecturas
                foreach ($kanji["readings"] as $reading) {
                    Reading::insert([
                        "kanji_id" => $newKanji->id,
                        "reading" => $reading["reading"],
                        "type" => $reading["type"],
                    ]);
                }

                //Añadir significados
                $meanings = array_slice($kanji["meanings"], 1);
                if ($meanings) {
                    foreach ($meanings as $meaning) {
                        Meaning::insert([
                            "kanji_id" => $newKanji->id,
                            "meaning" => $meaning,
                        ]);
                    }
                }
            }
        );
    }
}
