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
        Schema::create('glazes', function (Blueprint $table) {
            $table->id();
            $table->string('glaze_code');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->integer('fire_temp')->nullable();
            $table->date('approval_date')->nullable();
            $table->unsignedBigInteger('glaze_inside_id')->nullable();
            $table->unsignedBigInteger('glaze_outer_id')->nullable();
            $table->unsignedBigInteger('effect_id')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('glazes');
    }
};
