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
        Schema::create('purchase_order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id')->nullable();
            $table->unsignedBigInteger('sku_id')->nullable();
            $table->string('sku_code')->nullable();
            $table->text('description')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('unit_id')->nullable();
            $table->integer('price')->nullable();
            $table->decimal('discount', 5, 2)->nullable();
            $table->integer('total')->nullable();
            $table->string('tax_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_details');
    }
};
