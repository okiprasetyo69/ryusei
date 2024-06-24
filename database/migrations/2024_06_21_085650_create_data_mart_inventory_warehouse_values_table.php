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
        Schema::create('data_mart_inventory_warehouse_values', function (Blueprint $table) {
            $table->id();
            $table->integer('by_month')->nullable();
            $table->integer('by_year')->nullable();
            $table->string('sku_code')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('sell_price')->nullable();
            $table->bigInteger('total_inventory_item')->nullable();
            $table->date('sync_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_mart_inventory_warehouse_values');
    }
};
