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
            $table->string('glaze_code')->unique();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->integer('fire_temp')->nullable();
            $table->date('approval_date')->nullable();
            $table->unsignedBigInteger('glaze_inside_id')->nullable();
            $table->unsignedBigInteger('glaze_outer_id')->nullable();
            $table->unsignedBigInteger('effect_id')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // เพิ่ม foreign key constraints
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('set null');
            $table->foreign('glaze_inside_id')->references('id')->on('glaze_insides')->onDelete('set null');
            $table->foreign('glaze_outer_id')->references('id')->on('glaze_outers')->onDelete('set null');
            $table->foreign('effect_id')->references('id')->on('effects')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
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
