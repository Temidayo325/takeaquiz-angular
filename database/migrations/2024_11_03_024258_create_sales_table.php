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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->integer('event_id')
                    ->references('id')
                    ->on('events')->onDelete('cascade');
            $table->integer('user_id')
                    ->references('id')
                    ->on('users')->onDelete('cascade');
            $table->integer('ticket_id')
                    ->references('id')
                    ->on('tickets')->onDelete('cascade');
            $table->integer("purchased_tickets");
            $table->integer("amount_paid");
            $table->set('status', ['Pending', 'Failed', 'Success']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
