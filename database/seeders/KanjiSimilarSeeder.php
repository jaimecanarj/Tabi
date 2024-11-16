<?php

namespace Database\Seeders;

use App\Models\Kanji;
use DB;
use File;
use Illuminate\Database\Seeder;

class KanjiSimilarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/kanjiSimilar.json");
        $kanjis = collect(json_decode($json, true));

        $kanjis->each(
            callback: function ($kanji) {
                if (sizeof($kanji["similar"])) {
                    foreach ($kanji["similar"] as $similar) {
                        DB::table("kanji_similar")->insert([
                            "kanji_id" => Kanji::where(
                                "literal",
                                $kanji["kanji"]
                            )->first()->id,
                            "kanji_similar_id" => Kanji::where(
                                "literal",
                                $similar
                            )->first()->id,
                        ]);
                    }
                }
            }
        );
    }
}
