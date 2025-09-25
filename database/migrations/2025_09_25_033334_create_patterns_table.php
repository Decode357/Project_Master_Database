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
            $table->unsignedBigInteger('requestor_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('designer_id');
            $table->integer('duration')->nullable();
            $table->boolean('in_glaze')->default(false);
            $table->boolean('on_glaze')->default(false);
            $table->boolean('under_glaze')->default(false);
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
        Schema::dropIfExists('patterns');
    }
};
