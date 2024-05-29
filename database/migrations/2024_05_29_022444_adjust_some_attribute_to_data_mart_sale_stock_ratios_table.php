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
            // Remove
            $table->dropColumn('amount_off_grand_total');
            $table->dropColumn('amount_off_sell_price');
            $table->dropColumn('result_divide');

            // Create
            $table->string('salesorder_no')->nullable();
            $table->unsignedBigInteger('dwh_order_id')->nullable();
            $table->integer('total_stock')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('total_inventory')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_mart_sale_stock_ratios', function (Blueprint $table) {
            // Create
            $table->integer('amount_off_grand_total')->nullable();
            $table->integer('amount_off_sell_price')->nullable();
            $table->decimal('result_divide', 10,2)->nullable();

            // Remove
            $table->dropColumn('salesorder_no');
            $table->dropColumn('dwh_order_id');
            $table->dropColumn('total_stock');
            $table->dropColumn('amount');
            $table->dropColumn('total_inventory');
        });
    }
};
