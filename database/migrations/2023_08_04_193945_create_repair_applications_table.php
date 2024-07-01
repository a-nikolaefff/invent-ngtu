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
        Schema::create('repair_applications', function (Blueprint $table) {
            $table->id();
            $table->string('short_description');
            $table->text('full_description')->nullable();
            $table->text('response')->nullable();
            $table->date('application_date');
            $table->date('response_date')->nullable();
            $table->unsignedBigInteger('equipment_id');
            $table->unsignedBigInteger('repair_application_status_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('equipment_id')->references('id')
                ->on('equipment')->cascadeOnDelete();
            $table->foreign('repair_application_status_id')->references('id')
                ->on('repair_application_statuses')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')
                ->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_applications');
    }
};
