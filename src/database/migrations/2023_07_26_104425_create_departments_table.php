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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name')->nullable();
            $table->unsignedBigInteger('department_type_id')->nullable();
            $table->unsignedBigInteger('parent_department_id')->nullable();
            $table->timestamps();

            $table->foreign('department_type_id')->references('id')
                ->on('department_types')->nullOnDelete();
            $table->foreign('parent_department_id')->references('id')
                ->on('departments')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
