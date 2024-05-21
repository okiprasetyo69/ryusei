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
        Schema::create('data_mart_market_places', function (Blueprint $table) {
            $table->id();
        
            $table->unsignedBigInteger('channel_id')->nullable();
            $table->string('channel_name')->nullable();
            $table->string('store_name')->nullable();
            $table->integer('grand_total')->nullable();
            $table->date('transaction_date')->nullable();
            $table->date('sync_date')->nullable();
            
            $table->index('channel_name');
            $table->index('transaction_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_mart_market_places');
    }
};
