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
        Schema::create("radicals", function (Blueprint $table) {
            $table->id();
            $table->char("radical", length: 1);
            $table->string("significado", length: 50);
            $table->tinyInteger("trazos");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("radicals");
    }
};
