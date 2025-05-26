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
        Schema::create('class_hierarchies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_category_id')->nullable();
            $table->foreign('company_category_id')->references('id')->on('company_categories')->onDelete('cascade');
            $table->unsignedBigInteger('busines_unit_id')->nullable();
            $table->foreign('busines_unit_id')->references('id')->on('busines_units')->onDelete('cascade');
            $table->unsignedBigInteger('dept_by_business_unit_id')->nullable();
            $table->foreign('dept_by_business_unit_id')->references('id')->on('dept_by_business_units')->onDelete('cascade');
            $table->unsignedBigInteger('division_id')->unique()->nullable();
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_hierarchies');
    }
};
