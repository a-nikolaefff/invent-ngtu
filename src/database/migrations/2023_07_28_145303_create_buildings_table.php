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
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('address')->unique();
            $table->unsignedBigInteger('building_type_id')->nullable();
            $table->unsignedTinyInteger('floor_amount');
            $table->timestamps();

            $table->foreign('building_type_id')->references('id')
                ->on('building_types')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};
