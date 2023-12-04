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
        Schema::create('form_availabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('form_id');
            $table->dateTime('open_form_at')->nullable();
            $table->dateTime('close_form_at')->nullable();
            $table->unsignedInteger('response_count_limit')->nullable();
            $table->unsignedTinyInteger('available_weekday')->nullable();
            $table->time('available_start_time')->nullable();
            $table->time('available_end_time')->nullable();
            $table->text('closed_form_message')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_availabilities');
    }
};
