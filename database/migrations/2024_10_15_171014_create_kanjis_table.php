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
            $table->tinyInteger("grade");
            $table->tinyInteger("strokes");
            $table->string("meaning", length: 50);
            $table->smallInteger("frequency")->nullable();
            $table->smallInteger("heisig_index")->nullable();
            $table->smallInteger("wanikani_index")->nullable();
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
