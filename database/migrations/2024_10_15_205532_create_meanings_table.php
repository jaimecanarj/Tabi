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
        Schema::create("meanings", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignIdFor(Kanji::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->string("meaning", length: 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("meanings");
    }
};
