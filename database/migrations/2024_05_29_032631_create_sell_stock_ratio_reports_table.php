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
        Schema::create('sell_stock_ratio_reports', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date')->nullable();
            $table->bigInteger('total_sales_turn_over')->nullable();
            $table->bigInteger('total_inventory_value')->nullable();
            $table->decimal('sell_stock_ratio', 10,2)->nullable();
            $table->date('sync_date')->nullable();
            
            $table->index('transaction_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sell_stock_ratio_reports');
    }
};
