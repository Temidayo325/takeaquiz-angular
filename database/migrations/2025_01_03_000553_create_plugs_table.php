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
            $table->string('address')->nullable()->default(null);
            $table->integer('travel');
            $table->string('flier');
            $table->string('service');
            $table->text('service_summary');
            $table->text('usp')->nullable()->default(null);
            $table->text('social_media_links');
            $table->set('status', ['Active', 'Suspended', 'Inactive'])->default('Active');
            $table->boolean('isPremium')->default(false);
            $table->string('slug');
            $table->set('location_based', ['Hybrid', 'In-person', 'Remote']);
            $table->text('physical_address')->nullable()->default(null);
            $table->string('contact_email', 100)->nullable()->default(null);
            $table->string('contact_portfolio')->nullable()->default(null);
            $table->string('contact_whatsapp', 40)->nullable()->default(null);
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
