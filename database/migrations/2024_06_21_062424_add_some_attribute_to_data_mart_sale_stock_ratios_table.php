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
        Schema::table('data_mart_sale_stock_ratios', function (Blueprint $table) {
            $table->integer('total_item_sold')->nullable();
            $table->bigInteger('total_sell_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_mart_sale_stock_ratios', function (Blueprint $table) {
            $table->dropColumn('total_item_sold');
            $table->dropColumn('total_sell_price');
        });
    }
};
