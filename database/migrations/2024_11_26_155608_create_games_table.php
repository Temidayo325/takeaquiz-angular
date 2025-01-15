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
            $table->string('image')->nullable()->default(null);
            $table->text('materials');
            $table->text('difficulty_level');
            $table->text('category');
            $table->text('ideal_setting');
            $table->text('objective');
            $table->text('tips');
            $table->text('play_time');
            $table->string('video')->nullable()->default(null);
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
