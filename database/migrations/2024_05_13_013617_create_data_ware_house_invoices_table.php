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
        Schema::create('data_ware_house_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('doc_id')->nullable();
            $table->string('invoice_number')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_reference')->nullable();
            $table->date('transaction_date')->nullable();
            $table->date('due_date')->nullable();
            $table->integer('grand_total')->nullable();
            $table->integer('type')->nullable(); // 1 :  invoice
            $table->integer('due')->nullable(); //sisa
            $table->index('transaction_date');
            $table->date('sync_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_ware_house_invoices');
    }
};
