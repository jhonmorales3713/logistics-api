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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->unsignedBigInteger('itemType_id')->index();;
            // $table->unsignedBigInteger('cargoType_id'); // this one
            $table->string('email');
            $table->string('contactNumber');
            $table->string('referenceNumber')->default();
            $table->decimal('quantity',10, 2);
            $table->string('deliveryType');
            $table->string('status');
            $table->dateTime('targetDate');
            $table->timestamps();
            $table->unsignedBigInteger('cargoType_id')->index()->nullable();
            $table->foreign('cargoType_id')->references('id')->on('inquiries')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('itemType_id')->index()->nullable();
            $table->foreign('itemType_id')->references('id')->on('inquiries')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
