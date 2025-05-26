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
        Schema::create('chose_event_types', function (Blueprint $table) {
            $table->id();
            $table->string('route_name');
            $table->unsignedBigInteger('event_type_id')->nullable();
            $table->foreign('event_type_id')->references('id')->on('type_event_reports')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chose_event_types');
    }
};
