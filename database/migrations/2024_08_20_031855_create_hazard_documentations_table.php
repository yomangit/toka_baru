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
        Schema::create('hazard_documentations', function (Blueprint $table) {
            $table->id();
            $table->string('name_doc')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('hazard_id');
            $table->foreign('hazard_id')->references('id')->on('hazard_reports')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hazard_documentations');
    }
};
