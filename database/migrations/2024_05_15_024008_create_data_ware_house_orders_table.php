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
        Schema::create('data_ware_house_orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('salesorder_id')->nullable();
            $table->string('salesorder_no')->nullable();
            $table->string('invoice_number')->nullable();
            $table->date('invoice_created_date')->nullable();
            $table->date('transaction_date')->nullable();
            $table->boolean('is_paid')->nullable();
            $table->string('shipping_full_name')->nullable();
            $table->string('customer_name')->nullable();
            $table->integer('grand_total')->nullable();
            $table->string('store_name')->nullable();
            $table->unsignedBigInteger('channel_id')->nullable();
            $table->string('channel_name')->nullable();
            $table->string('shipper')->nullable();
            $table->string('store')->nullable();
            $table->integer('package_count')->nullable();
            // $table->boolean('cancel_reason')->nullable();
            // $table->boolean('cancel_reason_detail')->nullable();
            $table->string('wms_status')->nullable();
            $table->text('note')->nullable();
            $table->string('ref_no')->nullable();
            $table->string('tracking_number')->nullable();
            $table->boolean('is_cod')->nullable();

            $table->date('sync_date')->nullable();

            $table->index('transaction_date');
            $table->index('invoice_created_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_ware_house_orders');
    }
};
