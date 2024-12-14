<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstudioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    static int $intentos = 0;
    static int $aciertos = 0;
    static float $tiempo = 1;
    static int $fecha = 0;

    public function definition(): array
    {
        //Respueta entre 1 y 0, con 85% de 1
        $respuesta = $this->faker->numberBetween(1, 100) <= 85 ? 1 : 0;

        if ($respuesta) {
            self::$tiempo += log(self::$intentos + 1) * 86;
            self::$aciertos++;
        } else {
            self::$tiempo *= 0.8;
        }
        self::$intentos++;

        self::$fecha += $this->faker->numberBetween(3, 6);
        $fecha = Carbon::create(2024, 9, 25)->addDays(self::$fecha);

        return [
            "user_id" => 1,
            "kanji_id" => 1,
            "betaA" => 3,
            "betaB" => 3,
            "respuesta" => $respuesta,
            "tiempo" => self::$tiempo,
            "aciertos" => self::$aciertos,
            "intentos" => self::$intentos,
            "fecha" => $fecha,
        ];
    }

    public static function reset($fecha): void
    {
        self::$intentos = 0;
        self::$aciertos = 0;
        self::$tiempo = 1;
        self::$fecha = $fecha;
    }
}
