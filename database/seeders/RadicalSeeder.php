<?php

namespace Database\Seeders;

use App\Models\Radical;
use File;
use Illuminate\Database\Seeder;

class RadicalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get("database/json/radicals.json");
        $radicals = collect(json_decode($json, true));
        $radicals->each(
            callback: function ($radical) {
                Radical::insert([
                    "literal" => $radical["literal"],
                    "meaning" => $radical["meaning"],
                    "strokes" => $radical["strokes"],
                ]);
            }
        );
    }
}
