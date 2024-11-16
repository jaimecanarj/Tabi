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
        $json = File::get("database/json/radicales.json");
        $radicals = collect(json_decode($json, true));
        $radicals->each(
            callback: function ($radical) {
                Radical::insert([
                    "literal" => $radical["literal"],
                    "significado" => $radical["significado"],
                    "trazos" => $radical["trazos"],
                ]);
            }
        );
    }
}
