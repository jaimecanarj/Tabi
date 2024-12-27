<?php

namespace Database\Seeders;

use App\Models\Study;
use App\Models\User;
use Database\Factories\StudyFactory;
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
            "index" => "heisig",
            "daily_study" => 10,
            "admin" => true,
        ]);

        $this->call([
            KanjiSeeder::class,
            RadicalSeeder::class,
            KanjiRadicalSeeder::class,
            KanjiSimilarSeeder::class,
        ]);

        //Generar datos de estudio para el usuario 1
        $studyNumber = 20;
        $date = 0;
        foreach (range(1, 600) as $i) {
            if ($i % 30 == 0 && $i != 600) {
                $studyNumber = $studyNumber - 1;
                $date = $date + 4;
            }
            StudyFactory::reset($date);
            Study::factory($studyNumber)->create([
                "kanji_id" => $i,
            ]);
        }
    }
}
