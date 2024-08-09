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
        Schema::create('ware_house_section_products', function (Blueprint $table) {
            $table->id();

            $table->string('image_link');

            $table->unsignedBigInteger('warehouse_section_id');
            $table->unsignedBigInteger('section_type_id');
            $table->unsignedBigInteger('product_id');

            $table->foreign('warehouse_section_id')->on('warehouse_sections')->references('id');
            $table->foreign('product_id')->on('products')->references('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ware_house_section_products');
    }
};
