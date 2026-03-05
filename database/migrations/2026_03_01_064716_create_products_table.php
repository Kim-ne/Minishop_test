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
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->integer('qty');
            $table->decimal('price', 8, 3)->unsigned()->default(0);
            $table->string('image', 255);
            $table->string('alias', 255);
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->tinyInteger('status')->default(1);
            $table->string('sku', 255);
            $table->string('keywords', 50);
            $table->integer('supplier_id');
            $table->text('description');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
