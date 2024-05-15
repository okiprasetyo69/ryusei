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
        Schema::create('data_ware_house_order_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('dwh_order_id')->nullable();
            $table->unsignedBigInteger('sku_id')->nullable(); // item_id
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->integer('disc_marketplace')->nullable();
            $table->integer('price')->nullable();
            $table->integer('qty')->nullable();
            $table->string('unit')->nullable();
            $table->integer('qty_in_base')->nullable();
            $table->decimal('discount', 5, 2)->nullable(); // discount in percent
            $table->integer('disc_amount')->nullable();
            $table->integer('tax_amount')->nullable();
            $table->integer('amount')->nullable();
            $table->date('shipped_date')->nullable();
            $table->boolean('is_bundle')->nullable();
            $table->string('name')->nullable(); // item name
            $table->text('description')->nullable();
            $table->string('sku_code')->nullable();
            $table->integer('sell_price')->nullable();
            $table->integer('original_price')->nullable();
            $table->integer('rate')->nullable();
            $table->string('tax_name')->nullable();
            $table->integer('qty_picked')->nullable();

            $table->date('sync_date')->nullable();

            $table->index('dwh_order_id');
            $table->index('sku_id');
            $table->index('sku_code');
            $table->index('qty');
            $table->index('qty_in_base');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_ware_house_order_details');
    }
};
