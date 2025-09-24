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
        Schema::create('shapes', function (Blueprint $table) {
            $table->id(); // INT id PK

            $table->string('item_code')->unique(); // VARCHAR item_code
            $table->string('item_description_thai')->nullable(); // VARCHAR
            $table->string('item_description_eng')->nullable(); // VARCHAR

            // FK ต่าง ๆ
            $table->unsignedBigInteger('shape_type_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->unsignedBigInteger('shape_collection_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('item_group_id')->nullable();
            $table->unsignedBigInteger('process_id')->nullable();
            $table->unsignedBigInteger('designer_id')->nullable();
            $table->unsignedBigInteger('requestor_id')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();

            // ข้อมูลเชิงตัวเลข
            $table->integer('volume')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('long_diameter')->nullable();
            $table->integer('short_diameter')->nullable();
            $table->integer('height_long')->nullable();
            $table->integer('height_short')->nullable();
            $table->integer('body')->nullable();

            // วันอนุมัติ
            $table->date('approval_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shapes');
    }
};
