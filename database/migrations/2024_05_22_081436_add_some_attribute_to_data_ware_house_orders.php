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
            $table->integer('service_fee')->nullable();
            $table->integer('insurance_cost')->nullable();
            $table->integer('shipping_cost')->nullable();
            $table->integer('buyer_shipping_cost')->nullable();
            $table->integer('add_disc')->nullable();
            $table->integer('add_fee')->nullable();
            $table->integer('discount_marketplace')->nullable();
            $table->integer('total_amount_mp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_ware_house_orders', function (Blueprint $table) {
            $table->dropColumn('service_fee');
            $table->dropColumn('insurance_cost');
            $table->dropColumn('shipping_cost');
            $table->dropColumn('buyer_shipping_cost');
            $table->dropColumn('add_disc');
            $table->dropColumn('add_fee');
            $table->dropColumn('discount_marketplace');
            $table->dropColumn('total_amount_mp')->nullable();
        });
    }
};
