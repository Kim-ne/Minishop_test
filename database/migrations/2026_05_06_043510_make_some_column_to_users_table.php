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
        Schema::table('users', function (Blueprint $table) {
            $table->string('company')->nullable()->after('country');
            $table->string('address')->nullable()->after('company');
            $table->string('first_name')->nullable()->after('address');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('city')->nullable()->after('last_name');
            $table->string('Postal_code')->nullable()->after('city');
            $table->string('about_me', 255)->nullable()->after('Postal_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'company',
                'address',
                'first_name',
                'last_name',
                'city',
                'Postal_code',
                'about_me'
            ]);
        });
    }
};
