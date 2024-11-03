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
            $table->string("significado", length: 50);
            $table->smallInteger("frecuencia")->nullable();
            $table->smallInteger("indice_escolar")->nullable();
            $table->smallInteger("indice_heisig")->nullable();
            $table->smallInteger("indice_wanikani")->nullable();
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
