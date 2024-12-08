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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')
                    ->references('id')
                    ->on('users')->onDelete('cascade');
            $table->string('name', 100);
            $table->date('event_date');
            $table->string('starting_time'); 
            $table->string('state', 30);
            $table->string('coordinate', 150)->nullable()->default(null);
            $table->text('location');
            $table->text('tags');
            $table->set('status', ['Draft', 'Published'])->default('Draft');
            $table->string('flier')->nullable();
            $table->boolean('isPremium')->default(false);
            $table->text('promotional_copy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
