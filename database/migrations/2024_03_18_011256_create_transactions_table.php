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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_channel_id')->nullable();
            $table->string('order_number')->nullable();
            $table->string('tracking_number')->nullable();
            $table->string('sku_id')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('unit_price')->nullable();
            $table->date('order_date')->nullable();
            $table->date('process_order_date')->nullable();
            $table->smallInteger('group_id')->nullable(); // kloter
            $table->smallInteger('payment_method_id')->nullable(); // tipe pembayaran
            $table->string('postal_code')->nullable();
            $table->integer('total')->nullable();
            $table->integer('admin_charge')->nullable();
            $table->integer('total_net')->nullable();
            $table->decimal('discount', 5, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
