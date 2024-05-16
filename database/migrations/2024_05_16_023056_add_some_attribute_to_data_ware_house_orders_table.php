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
        Schema::table('data_ware_house_orders', function (Blueprint $table) {
            $table->integer('sub_total')->nullable();
            $table->integer('total_disc')->nullable();
            $table->integer('total_tax')->nullable();
            $table->string('payment_method')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_ware_house_orders', function (Blueprint $table) {
            $table->dropColumn('sub_total');
            $table->dropColumn('total_disc');
            $table->dropColumn('total_tax');
            $table->dropColumn('payment_method');
        });
    }
};
