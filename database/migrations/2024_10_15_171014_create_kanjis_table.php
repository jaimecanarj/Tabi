<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("kanjis", function (Blueprint $table) {
            $table->id();
            $table->string("literal");
            $table->integer("grado");
            $table->integer("trazos");
            $table->integer("frecuencia")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("kanjis");
    }
};
