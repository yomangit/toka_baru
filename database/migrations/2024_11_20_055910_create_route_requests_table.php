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
        Schema::create('route_requests', function (Blueprint $table) {
            $table->id();
            $table->string('route_name');
            $table->unsignedBigInteger('workflow_template_id')->nullable();
            $table->foreign('workflow_template_id')->references('id')->on('workflow_administrations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_requests');
    }
};
