<?php

namespace Database\Seeders;

use App\Models\Kanji;
use App\Models\Radical;
use DB;
use File;
use Illuminate\Database\Seeder;

class KanjiRadicalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/kanjiRadicals.json");
        $relations = collect(json_decode($json, true));

        $relations->each(function ($relation) {
            foreach ($relation["radicals"] as $radical) {
                DB::table("kanji_radical")->insert([
                    "kanji_id" => Kanji::where(
                        "literal",
                        $relation["kanji"]
                    )->first()->id,
                    "radical_id" => Radical::where(
                        "literal",
                        "like",
                        $radical
                    )->first()->id,
                ]);
            }
        });
    }
}
