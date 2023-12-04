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
        Schema::create('conditional_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('form_id');
            $table->unsignedInteger('field_id');
            $table->string('field_name');
            $table->string('value');
            $table->string('display');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conditional_fields');
    }
};
