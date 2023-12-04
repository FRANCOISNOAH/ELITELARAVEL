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
        Schema::create('sign_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->on('users')->onDelete('cascade');
            $table->string("description");
            $table->integer('error_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sign_histories');
    }
};
