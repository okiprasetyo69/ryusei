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
        Schema::create('sales_returns', function (Blueprint $table) {
            $table->id();
            $table->integer('doc_id')->nullable();
            $table->string('doc_number')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_reference')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('invoice_number')->nullable(); // Ref No
            $table->date('transaction_date')->nullable();
            $table->date('due_date')->nullable();
            $table->integer('sub_total')->nullable();
            $table->integer('grand_total')->nullable();
            $table->integer('due')->nullable(); // sisa
            $table->integer('downpayment_amount')->nullable();
            $table->string('doc_type')->nullable();
            $table->integer('age')->nullable();
            $table->integer('age_due')->nullable();
            $table->string('store_name')->nullable();
            $table->string('return_type')->nullable();
            $table->text('note')->nullable();
            $table->integer('total_tax')->nullable();
            $table->integer('total_disc')->nullable();
            $table->integer('add_disc')->nullable();
            $table->integer('add_fee')->nullable();
            $table->integer('service_fee')->nullable();
            $table->string('salesorder_no')->nullable();
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
        Schema::dropIfExists('sales_returns');
    }
};
