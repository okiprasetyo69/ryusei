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
        Schema::create('data_ware_house_detail_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->unsignedBigInteger('sku_id')->nullable();
            $table->string('sku_code')->nullable();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('price')->nullable();
            $table->decimal('discount', 5, 2)->nullable();
            $table->integer('disc_amount')->nullable();
            $table->string('unit')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('tax_amount')->nullable();
            $table->integer('sell_price')->nullable();
            $table->integer('original_price')->nullable();
            $table->date('sync_date')->nullable();

            $table->index('invoice_id');
            $table->index('sku_id');
            $table->index('sku_code');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_ware_house_detail_invoices');
    }
};
