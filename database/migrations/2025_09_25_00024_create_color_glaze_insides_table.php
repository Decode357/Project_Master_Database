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
        Schema::create('color_glaze_insides', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('glaze_inside_id');
            $table->unsignedBigInteger('color_id');
            $table->timestamps();

            // Define foreign keys
            $table->foreign('glaze_inside_id')->references('id')->on('glaze_insides')->onDelete('cascade');
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('color_glaze_insides');
    }
};
