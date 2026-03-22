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
        Schema::table('order_product', function (Blueprint $table) {
            $table->foreignId('order_id')->nullable()->change();
            $table->foreignId('product_id')->nullable()->change();
            $table->tinyInteger('status')->default(1)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_product', function (Blueprint $table) {
            $table->foreignId('order_id')->change();
            $table->foreignId('product_id')->change();
            $table->tinyInteger('status')->default(1)->change();
        });
    }
};
