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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // PK
            $table->string('product_sku')->unique();
            $table->string('product_name');
            // FK
            $table->unsignedBigInteger('status_id')->nullable();
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->unsignedBigInteger('shape_id')->nullable();
            $table->unsignedBigInteger('glaze_id')->nullable();
            $table->unsignedBigInteger('pattern_id')->nullable();
            $table->unsignedBigInteger('backstamp_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();

            $table->timestamps();

            // เพิ่ม foreign key constraints
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('set null');
            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('set null');
            $table->foreign('shape_id')->references('id')->on('shapes')->onDelete('set null');
            $table->foreign('glaze_id')->references('id')->on('glazes')->onDelete('set null');
            $table->foreign('pattern_id')->references('id')->on('patterns')->onDelete('set null');
            $table->foreign('backstamp_id')->references('id')->on('backstamps')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('image_id')->references('id')->on('images')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
