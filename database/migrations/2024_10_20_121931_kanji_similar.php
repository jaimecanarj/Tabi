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
        Schema::create("kanji_similar", function (Blueprint $table) {
            $table
                ->foreignIdFor(Kanji::class)
                ->constrained()
                ->cascadeOnDelete();
            $table
                ->foreignIdFor(Kanji::class, "kanji_similar_id")
                ->constrained("kanjis")
                ->cascadeOnDelete();
            $table->primary(["kanji_id", "kanji_similar_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("kanji_similar");
    }
};
