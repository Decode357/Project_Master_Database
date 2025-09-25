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
        Schema::create('patterns', function (Blueprint $table) {
            $table->id();
            $table->string('pattern_code');
            $table->string('pattern_name');
            $table->unsignedBigInteger('requestor_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->unsignedBigInteger('designer_id')->nullable();
            $table->integer('duration')->nullable();
            $table->boolean('in_glaze')->default(false);
            $table->boolean('on_glaze')->default(false);
            $table->boolean('under_glaze')->default(false);
            $table->date('approval_date')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->timestamps();

            // เพิ่ม foreign key constraints
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('set null');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('requestor_id')->references('id')->on('requestors')->onDelete('set null');
            $table->foreign('image_id')->references('id')->on('images')->onDelete('set null');
            $table->foreign('designer_id')->references('id')->on('designers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patterns');
    }
};
