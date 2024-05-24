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
        Schema::create('data_mart_sale_stock_ratios', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date')->nullable();
            $table->string('sku_code')->nullable();
            $table->integer('amount_off_grand_total')->nullable();
            $table->integer('amount_off_sell_price')->nullable();
            $table->decimal('result_divide', 10,2)->nullable();
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
        Schema::dropIfExists('data_mart_sale_stock_ratios');
    }
};
