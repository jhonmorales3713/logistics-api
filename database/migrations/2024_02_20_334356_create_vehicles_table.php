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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plateNumber')->unique();
            $table->integer('year');
            $table->string('color');
            $table->string('vin')->unique();
            $table->string('transmission');
            $table->string('chassisNumber')->unique();
            $table->string('status');
            $table->dateTime('registryExpiration');
            $table->dateTime('registryDate');
            $table->dateTime('lastMaintennanceDate');
            $table->decimal('maxLoad',10, 2);
            $table->decimal('price',10, 2);
            $table->decimal('mileAge',10, 2);
            $table->integer('wheelCount');
            $table->unsignedBigInteger('make_id')->index()->nullable();
            $table->unsignedBigInteger('type_id')->index()->nullable();
            $table->unsignedBigInteger('model_id')->index()->nullable();
            $table->unsignedBigInteger('gasType_id')->index()->nullable();
            $table->foreign('make_id')->references('id')->on('vehicles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('vehicles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('model_id')->references('id')->on('vehicles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('gasType_id')->references('id')->on('vehicles')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
