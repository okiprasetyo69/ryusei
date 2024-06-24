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
        Schema::table('sell_stock_ratio_reports', function (Blueprint $table) {
            $table->integer('month')->nullable();
            $table->integer('year')->nullable();
            $table->bigInteger('total_inventory_in_warehouse')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sell_stock_ratio_reports', function (Blueprint $table) {
            $table->dropColumn('month');
            $table->dropColumn('year');
            $table->dropColumn('total_inventory_in_warehouse');
        });
    }
};
