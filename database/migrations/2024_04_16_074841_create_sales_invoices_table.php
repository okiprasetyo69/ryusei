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
        Schema::create('sales_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->nullable();
            $table->string('batch_number')->nullable();
            $table->integer('type')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_reference')->nullable();
            $table->date('date')->nullable();
            $table->date('due_date')->nullable();
            $table->integer('day')->nullable();
            $table->integer('category_invoice_id')->nullable();
            $table->integer('warehouse_id')->nullable();
            $table->string('sales_person')->nullable();
            $table->string('journal_memo')->nullable();
            $table->text('note')->nullable();
            $table->integer('additional_char')->nullable();
            $table->integer('down_pmt')->nullable();
            $table->decimal('tax', 5, 2)->nullable();
            $table->decimal('pph_percent', 5, 2)->nullable();
            $table->integer('subtotal')->nullable();
            $table->decimal('discount', 5, 2)->nullable();
            $table->integer('grand_total')->nullable();
            $table->integer('balance_due')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_invoices');
    }
};
