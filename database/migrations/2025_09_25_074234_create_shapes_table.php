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
            $table->id(); // PK

            $table->string('item_code')->unique(); 
            $table->string('item_description_thai')->nullable();
            $table->string('item_description_eng')->nullable();

            // FK
            $table->unsignedBigInteger('shape_type_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->unsignedBigInteger('shape_collection_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('item_group_id')->nullable();
            $table->unsignedBigInteger('process_id')->nullable();
            $table->unsignedBigInteger('designer_id')->nullable();
            $table->unsignedBigInteger('requestor_id')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();

            // NEW: updated_by
            $table->unsignedBigInteger('updated_by')->nullable();

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

            // เพิ่ม foreign key constraints
            $table->foreign('shape_type_id')->references('id')->on('shape_types')->onDelete('set null');
            $table->foreign('shape_collection_id')->references('id')->on('shape_collections')->onDelete('set null');
            $table->foreign('process_id')->references('id')->on('processes')->onDelete('set null');
            $table->foreign('item_group_id')->references('id')->on('item_groups')->onDelete('set null');
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('set null');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('designer_id')->references('id')->on('designers')->onDelete('set null');
            $table->foreign('requestor_id')->references('id')->on('requestors')->onDelete('set null');
            $table->foreign('image_id')->references('id')->on('images')->onDelete('set null');

            // NEW: foreign key updated_by → users.id
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
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
