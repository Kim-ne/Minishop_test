<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('code', 6)->change();
            $table->timestamp('order_date')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'))->change();
            $table->decimal('total_amount', 12, 2)->nullable()->change();
            $table->foreignId('customer_id')->nullable()->change();
            $table->string('notes')->nullable()->change();
            $table->tinyInteger('status')->default(1)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('code',5)->change();
            $table->timestamp('order_date')->nullable()->change();
            $table->foreignId('customer_id')->change();
            $table->string('notes')->change();
            $table->tinyInteger('status')->change();
        });
    }
};
