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
        Schema::create('class_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deckmaster_id')->constrained('users');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('type'); // lecture или individual
            $table->dateTime('start_at');
            $table->integer('duration'); // в минутах
            $table->integer('capacity')->nullable(); // сколько мест
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_sessions');
    }
};
