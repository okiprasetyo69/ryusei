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
        Schema::table('sales_invoices', function (Blueprint $table) {
            $table->integer('state')->nullable(); // 0 & 1 : Open and Close, 2 : draft , 3 : Void
            $table->integer('is_deleted')->nullable(); // 0 : not delete , 1 : deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_invoices', function (Blueprint $table) {
            $table->dropColumn('state');
            $table->dropColumn('is_deleted');
        });
    }
};
