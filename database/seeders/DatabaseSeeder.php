<?php

namespace Database\Seeders;

use App\Models\Estudio;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\EstudioFactory;
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

        //Generar datos de estudio para el usuario 1
        $studyNumber = 20;
        $fecha = 0;
        foreach (range(1, 200) as $i) {
            if ($i % 10 == 0) {
                $studyNumber = $studyNumber - 1;
                $fecha = $fecha + 4;
            }
            EstudioFactory::reset($fecha);
            Estudio::factory($studyNumber)->create([
                "kanji_id" => $i,
            ]);
        }
    }
}
