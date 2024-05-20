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
        Schema::create('data_mart_product_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sku_id')->nullable();
            $table->string('sku_code')->nullable();
            $table->string('product_name')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('category_name')->nullable();
            $table->unsignedBigInteger('channel_id')->nullable();
            $table->string('channel_name')->nullable();
            $table->unsignedBigInteger('qty_sold')->nullable();
            $table->integer('grand_total')->nullable();
            $table->date('date')->nullable();

            $table->index('sku_code');
            $table->index('product_name');
            $table->index('category_name');
            $table->index('channel_name');
            $table->index('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_mart_product_details');
    }
};
