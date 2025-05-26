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
        Schema::create('workflow_applicables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_event_report_id')->nullable();
            $table->foreign('type_event_report_id')->references('id')->on('type_event_reports')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_applicables');
    }
};
