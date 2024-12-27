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
            $table->char("literal", length: 1);
            $table->string("meaning", length: 50);
            $table->tinyInteger("strokes");
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
