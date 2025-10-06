<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_categories', function (Blueprint $table) {
            // Primary key
            $table->id();

            // ชื่อหมวดหมู่
            $table->string('category_name');

            // หมวดหมู่แม่ (self reference)
            $table->foreignId('parent_category_id')
                  ->nullable()
                  ->constrained('product_categories')
                  ->onDelete('cascade');

            // เวลาสร้าง/อัปเดต
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};

