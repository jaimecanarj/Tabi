<?php

use App\Models\Kanji;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("estudios", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignIdFor(Kanji::class)
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->timestamp("fecha");
            $table->double("tiempo");
            $table->double("betaA");
            $table->double("betaB");
            $table->boolean("respuesta");
            $table->tinyInteger("aciertos");
            $table->tinyInteger("intentos");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("estudios");
    }
};
