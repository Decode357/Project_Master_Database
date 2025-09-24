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
        Schema::create('backstamps', function (Blueprint $table) {
            $table->id();
            $table->string('backstamp_code');
            $table->string('name');
            $table->unsignedBigInteger('requestor_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('status_id');
            $table->integer('duration')->nullable();
            $table->boolean('in_glaze')->default(false);
            $table->boolean('on_glaze')->default(false);
            $table->boolean('under_glaze')->default(false);
            $table->boolean('air_dry')->default(false);
            $table->date('approval_date')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backstamps');
    }
};
