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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('purchaseorder_number')->nullable();
            $table->string('batch_number')->nullable();
            $table->integer('type')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->string('vendor_reference')->nullable();
            $table->string('vendor_phone')->nullable();
            $table->date('date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->integer('day')->nullable();
            $table->integer('category_invoice_id')->nullable();
            $table->integer('warehouse_id')->nullable();
            $table->date('transaction_date')->nullable();
            $table->text('note')->nullable();
            $table->integer('subtotal')->nullable();
            $table->decimal('discount_invoice', 5, 2)->nullable();
            $table->integer('additional_char')->nullable();
            $table->decimal('tax', 5, 2)->nullable();
            $table->integer('grand_total')->nullable();
            $table->integer('down_pmt')->nullable();
            $table->integer('state')->nullable(); // 0 & 1 : Open and Close, 2 : draft , 3 : Void
            $table->integer('is_deleted')->nullable(); // 0 : not delete , 1 : deleted
            $table->string('bills')->nullable();
            $table->integer('purchaseorder_id')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
