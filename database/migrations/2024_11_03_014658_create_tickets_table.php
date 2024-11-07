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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id')
                    ->references('id')
                    ->on('events')->onDelete('cascade');
            $table->integer('price');
            $table->integer('total_seat');
            $table->integer('available_seat');
            $table->set('type', ['Early bird', 'General admission', 'VIP']);
            $table->set('access_type', ['Purchase', 'Gift']);
            $table->text('type_copy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
