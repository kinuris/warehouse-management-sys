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
        Schema::create('incoming_deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('distributor');

            $table->foreignId('product_id')
                ->references('id')
                ->on('products');
            
            $table->integer('quantity');
            $table->dateTime('delivery');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incoming_deliveries');
    }
};
