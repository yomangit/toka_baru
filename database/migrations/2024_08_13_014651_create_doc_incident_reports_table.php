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
        Schema::create('doc_incident_reports', function (Blueprint $table) {
            $table->id();
            $table->string('name_doc')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('incident_id');
            $table->foreign('incident_id')->references('id')->on('incident_reports')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doc_incident_reports');
    }
};
