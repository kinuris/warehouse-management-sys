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
        Schema::create('warehouse_sections', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('image_link');
            $table->unsignedBigInteger('warehouse_id');

            $table->foreign('warehouse_id')->on('warehouses')->references('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_sections');
    }
};
