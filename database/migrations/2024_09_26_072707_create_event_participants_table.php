<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('event_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_involvement_id');
            $table->foreign('type_involvement_id')->references('id')->on('type_involvements')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('type_event_report_id');
            $table->foreign('type_event_report_id')->references('id')->on('type_event_reports')->onDelete('cascade');
            $table->unsignedBigInteger('eventsubtype_id');
            $table->foreign('eventsubtype_id')->references('id')->on('eventsubtypes')->onDelete('cascade');
            $table->string('reference')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_participants');
    }
};
