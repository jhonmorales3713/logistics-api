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
        Schema::create('shipment_request_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipment_request_id');
            $table->foreign('shipment_request_id')->references('id')->on('shipment_requests')->onDelete('cascade');
            $table->decimal('quantity',10, 2);
            $table->string('name');
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_request_items');
    }
};
