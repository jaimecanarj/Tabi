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
        Schema::create("readings", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignIdFor(Kanji::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->string("reading", length: 20);
            $table->enum("type", ["onyomi", "kunyomi"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("readings");
    }
};
