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
        Schema::create('shipment_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inquiry_id')->index()->nullable();
            $table->unsignedBigInteger('vehicle_id')->index()->nullable();
            $table->unsignedBigInteger('consignee_id')->index()->nullable();
            $table->foreign('inquiry_id')->references('id')->on('inquiries')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('consignee_id')->references('id')->on('consignees')->onUpdate('cascade')->onDelete('cascade');
            $table->date('estimatedDeliveryDate');
            $table->string('status');
            $table->string('destination');
            $table->string('origin');
            $table->timestamps();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_requests');
    }
};
