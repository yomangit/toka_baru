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
        Schema::create('type_event_reports', function (Blueprint $table) {
            $table->id();
            $table->string('type_eventreport_name')->nullable();
            $table->unsignedBigInteger('event_category_id')->nullable();
            $table->foreign('event_category_id')->references('id')->on('event_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_event_reports');
    }
};
