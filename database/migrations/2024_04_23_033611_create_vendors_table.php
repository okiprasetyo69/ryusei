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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_code')->nullable();
            $table->string('name')->nullable();
            $table->string('alias')->nullable();
            $table->string('branch')->nullable();
            $table->string('category')->nullable();
            $table->integer('currency')->nullable(); // 0 : IDR , 1 : US Dollar
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->integer('is_tax_on_purchase')->nullable();
            $table->integer('balance')->nullable();
            $table->string('city')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
