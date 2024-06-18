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
            $table->bigInteger('total_inventory')->change();
            $table->bigInteger('amount')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_mart_sale_stock_ratios', function (Blueprint $table) {
            $table->integer('total_inventory')->change();
            $table->integer('amount')->change();
        });
    }
};
