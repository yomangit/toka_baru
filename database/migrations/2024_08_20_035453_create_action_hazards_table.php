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
        Schema::create('action_hazards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hazard_id');
            $table->foreign('hazard_id')->references('id')->on('hazard_reports')->onDelete('cascade');
            $table->text('followup_action')->nullable();
            $table->text('actionee_comment')->nullable();
            $table->text('action_condition')->nullable();
            $table->unsignedBigInteger('responsibility');
            $table->foreign('responsibility')->references('id')->on('users')->onDelete('cascade');
            $table->string('due_date')->nullable();
            $table->string('completion_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_hazards');
    }
};
