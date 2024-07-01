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
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->string('short_description');
            $table->string('full_description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedBigInteger('equipment_id');
            $table->unsignedBigInteger('repair_type_id')->nullable();
            $table->unsignedBigInteger('repair_status_id');
            $table->timestamps();

            $table->foreign('equipment_id')->references('id')
                ->on('equipment')->cascadeOnDelete();
            $table->foreign('repair_type_id')->references('id')
                ->on('repair_types')->nullOnDelete();
            $table->foreign('repair_status_id')->references('id')
                ->on('repair_statuses')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};
