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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('name');
            $table->string('description')->nullable();
            $table->date('acquisition_date')->nullable();
            $table->boolean('not_in_operation');

            $table->boolean('decommissioned');
            $table->date('decommissioning_date')->nullable();
            $table->string('decommissioning_reason')->nullable();

            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('equipment_type_id')->nullable();

            $table->timestamps();

            $table->foreign('room_id')->references('id')
                ->on('rooms')->cascadeOnDelete();
            $table->foreign('equipment_type_id')->references('id')
                ->on('equipment_types')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
