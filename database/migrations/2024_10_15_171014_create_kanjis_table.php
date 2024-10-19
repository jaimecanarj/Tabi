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
            $table->char("literal", length: 1);
            $table->tinyInteger("grado");
            $table->tinyInteger("trazos");
            $table->smallInteger("frecuencia")->nullable();
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