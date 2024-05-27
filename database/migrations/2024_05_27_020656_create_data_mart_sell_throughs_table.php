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
        Schema::create('data_mart_sell_throughs', function (Blueprint $table) {
            $table->id();

            $table->string('sku_code')->nullable();
            $table->string('product_name')->nullable();
            $table->integer('total_unit_received')->nullable();
            $table->integer('total_unit_sold')->nullable();
            $table->decimal('sell_through', 10,2)->nullable();
            $table->date('sync_date')->nullable();

            $table->index('sync_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_mart_sell_throughs');
    }
};
