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
        Schema::create('employee_task_queues', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description');

            $table->enum('status', ['Pending', 'Completed', 'Failed']);

            $table->unsignedBigInteger('user_id');

            $table->foreign('user_id')->on('users')->references('id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_task_queues');
    }
};
