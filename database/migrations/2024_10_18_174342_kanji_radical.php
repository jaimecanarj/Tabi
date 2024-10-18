<?php

use App\Models\Kanji;
use App\Models\Radical;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("kanji_radical", function (Blueprint $table) {
            $table->foreignIdFor(Kanji::class);
            $table->foreignIdFor(Radical::class);
            $table->primary(["kanji_id", "radical_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("kanji_radical");
    }
};
