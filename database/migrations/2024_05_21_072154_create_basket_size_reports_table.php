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
        Schema::create('basket_size_reports', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date')->nullable();
            $table->integer('total_order_number')->nullable();
            $table->integer('grand_total')->nullable();
            $table->decimal('result_divide', 10,2)->nullable();
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
        Schema::dropIfExists('basket_size_reports');
    }
};
