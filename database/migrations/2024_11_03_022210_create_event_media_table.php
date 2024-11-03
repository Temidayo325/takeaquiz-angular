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
        Schema::create('event_media', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id')
                    ->references('id')
                    ->on('events')->onDelete('cascade');
            $table->integer('user_id')
                    ->references('id')
                    ->on('users')->onDelete('cascade');
            $table->text('video_gallery');
            $table->text('image_gallery');
            $table->string('flier');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_media');
    }
};
