<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            "email" => "prueba@mail.com",
            "name" => "prueba",
            "password" => "probando",
            "indice" => "escolar",
            "estudio_diario" => 10,
        ]);

        $this->call([
            KanjiSeeder::class,
            RadicalSeeder::class,
            KanjiRadicalSeeder::class,
            KanjiSimilarSeeder::class,
        ]);
    }
}
