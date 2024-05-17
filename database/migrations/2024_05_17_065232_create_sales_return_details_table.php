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
        Schema::create('sales_return_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sales_return_id')->nullable();
            $table->unsignedBigInteger('sku_id')->nullable(); // item_id
            $table->text('description')->nullable();
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->integer('price')->nullable();
            $table->integer('qty')->nullable();
            $table->string('unit')->nullable();
            $table->integer('qty_in_base')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('cogs')->nullable();
            $table->integer('tax_amount')->nullable();
            $table->decimal('discount', 5, 2)->nullable(); // discount in percent
            $table->integer('disc_amount')->nullable();
            $table->string('sku_code')->nullable();
            $table->string('name')->nullable(); // item name
            $table->integer('sell_price')->nullable();
            $table->integer('original_price')->nullable();
            $table->integer('rate')->nullable();
            $table->string('tax_name')->nullable();
            $table->integer('available_qty')->nullable();

            $table->date('sync_date')->nullable();
            
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
        Schema::dropIfExists('sales_return_details');
    }
};
