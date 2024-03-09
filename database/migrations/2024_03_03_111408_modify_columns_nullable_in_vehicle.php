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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->integer('year')->nullable()->change();
            $table->string('color')->nullable()->change();
            $table->dateTime('registryExpiration')->nullable()->change();
            $table->dateTime('registryDate')->nullable()->change();
            $table->dateTime('lastMaintennanceDate')->nullable()->change();
            $table->decimal('maxLoad',10, 2)->nullable()->change();
            $table->decimal('price',10, 2)->nullable()->change();
            $table->decimal('mileAge',10, 2)->nullable()->change();
            $table->integer('wheelCount')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->integer('year')->nullable(false)->change();
            $table->string('color')->nullable(false)->change();
            $table->dateTime('registryExpiration')->nullable(false)->change();
            $table->dateTime('registryDate')->nullable(false)->change();
            $table->dateTime('lastMaintennanceDate')->nullable(false)->change();
            $table->decimal('maxLoad',10, 2)->nullable(false)->change();
            $table->decimal('price',10, 2)->nullable(false)->change();
            $table->decimal('mileAge',10, 2)->nullable(false)->change();
            $table->integer('wheelCount')->nullable(false)->change();
        });
    }
};
