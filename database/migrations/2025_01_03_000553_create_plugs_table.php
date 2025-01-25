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
        Schema::create('plugs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')
                    ->unique()
                    ->references('id')
                    ->on('users')->onDelete('cascade');
            $table->string('state');
            $table->text('tags');
            $table->string('address');
            $table->integer('travel');
            $table->string('flier');
            $table->string('service');
            $table->text('service_summary');
            $table->text('usp')->nullable()->default(null);
            $table->text('social_media_links');
            $table->set('status', ['Active', 'Suspended', 'Inactive'])->default('Active');
            $table->boolean('isPremium')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plugs');
    }
};
