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
        Schema::create('workflow_details', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('status_event_id')->nullable();
            $table->foreign('status_event_id')->references('id')->on('status_events')->onDelete('cascade');
            $table->unsignedBigInteger('responsible_role_id')->nullable();
            $table->foreign('responsible_role_id')->references('id')->on('responsible_roles')->onDelete('cascade');
            $table->unsignedBigInteger('workflow_administration_id')->nullable();
            $table->foreign('workflow_administration_id')->references('id')->on('workflow_administrations')->onDelete('cascade');
            $table->string('destination_1')->nullable();
            $table->string('destination_1_label')->nullable();
            $table->string('destination_2')->nullable();
            $table->string('destination_2_label')->nullable();
            $table->string('is_cancel_step')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_details');
    }
};
