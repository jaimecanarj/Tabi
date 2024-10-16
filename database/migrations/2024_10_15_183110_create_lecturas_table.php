<?php

use App\Models\Kanji;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("lecturas", function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Kanji::class);
            $table->string("lectura", length: 20);
            $table->enum("tipo", ["onyomi", "kunyomi"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("lecturas");
    }
};
