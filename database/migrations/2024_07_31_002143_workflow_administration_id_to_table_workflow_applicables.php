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
        Schema::table('workflow_applicables', function (Blueprint $table) {
            $table->unsignedBigInteger('workflow_administration_id')->nullable();
            $table->foreign('workflow_administration_id')->references('id')->on('workflow_administrations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workflow_applicables', function (Blueprint $table) {
            $table->unsignedBigInteger('workflow_administration_id')->nullable();
            $table->foreign('workflow_administration_id')->references('id')->on('workflow_administrations')->onDelete('cascade');
        });
    }
};
