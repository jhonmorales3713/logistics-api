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
        Schema::create('user_user_role', function (Blueprint $table) {
            
            // Foreign key for the user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Foreign key for the role
            $table->foreignId('user_role_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_users_role');
    }
};
