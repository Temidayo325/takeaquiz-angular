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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('summary');
            $table->longText('stepByStep');
            $table->integer('minimum_player');
            $table->string('maximum_player');
            $table->text('tags');
            $table->string('video')->nullable()->default(null);
            $table->text('materials');
            $table->text('difficulty_level');
            $table->text('category');
            $table->text('ideal_setting')->nullable()->default(null);
            $table->text('tips')->nullable()->default(null);
            $table->text('play_time')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
