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
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');  // ชื่อไฟล์
            $table->string('file_path');  // path เช่น 'uploads/shapes/img001.jpg'
            $table->timestamps();

            $table->unsignedBigInteger('shape_id')->nullable();
            $table->unsignedBigInteger('glaze_id')->nullable();
            $table->unsignedBigInteger('pattern_id')->nullable();
            $table->unsignedBigInteger('backstamp_id')->nullable();
            

            // เพิ่ม foreign key constraints
            $table->foreign('shape_id')->references('id')->on('shapes')->onDelete('cascade');
            $table->foreign('glaze_id')->references('id')->on('glazes')->onDelete('cascade');
            $table->foreign('pattern_id')->references('id')->on('patterns')->onDelete('cascade');
            $table->foreign('backstamp_id')->references('id')->on('backstamps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
