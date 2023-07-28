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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('number');
            $table->unsignedBigInteger('room_type_id')->nullable();
            $table->unsignedBigInteger('building_id');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->timestamps();

            $table->foreign('room_type_id')->references('id')
                ->on('room_types')->nullOnDelete();
            $table->foreign('building_id')->references('id')
                ->on('buildings')->cascadeOnDelete();
            $table->foreign('department_id')->references('id')
                ->on('departments')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
