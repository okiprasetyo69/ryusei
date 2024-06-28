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
        Schema::table('developments', function (Blueprint $table) {
            $table->string('article')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->json('qty_per_size')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('status')->nullable(); // 1 : PO , 2 : Film , 3 : Sampling, 4 : Production
            $table->date('film_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('developments', function (Blueprint $table) {
            $table->dropColumn('article');
            $table->dropColumn('category_id');
            $table->dropColumn('vendor_id');
            $table->dropColumn('qty_per_size');
            $table->dropColumn('status');
            $table->dropColumn('film_date');
        });
    }
};
