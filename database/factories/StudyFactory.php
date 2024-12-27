<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    static int $attempts = 0;
    static int $successes = 0;
    static float $time = 1;
    static int $date = 0;

    public function definition(): array
    {
        //Respueta entre 1 y 0, con 85% de 1
        $answer = $this->faker->numberBetween(1, 100) <= 85 ? 1 : 0;

        if ($answer) {
            self::$time += log(self::$attempts + 1) * 86;
            self::$successes++;
        } else {
            self::$time *= 0.8;
        }
        self::$attempts++;

        self::$date += $this->faker->numberBetween(3, 6);
        $date = Carbon::create(2024, 9, 25)->addDays(self::$date);

        return [
            "user_id" => 1,
            "kanji_id" => 1,
            "betaA" => 3,
            "betaB" => 3,
            "answer" => $answer,
            "time" => self::$time,
            "successes" => self::$successes,
            "attempts" => self::$attempts,
            "date" => $date,
        ];
    }

    public static function reset($date): void
    {
        self::$attempts = 0;
        self::$successes = 0;
        self::$time = 1;
        self::$date = $date;
    }
}
