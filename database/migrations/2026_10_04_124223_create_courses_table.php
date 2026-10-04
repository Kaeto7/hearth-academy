<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deckmaster_id')->constrained('users');
            $table->foreignId('deck_id')->constrained('decks');
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2)->default(0);
            $table->string('status')->default('draft');
            $table->timestamps();
            $table->softDeletes();
            // difficulty намеренно пропущено — добавим отдельной миграцией
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
