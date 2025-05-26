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
        Schema::create('table_risk_assessments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('risk_assessment_id')->nullable();
            $table->foreign('risk_assessment_id')->references('id')->on('risk_assessments')->onDelete('cascade');
            $table->unsignedBigInteger('risk_consequence_id')->nullable();
            $table->foreign('risk_consequence_id')->references('id')->on('risk_consequences')->onDelete('cascade');
            $table->unsignedBigInteger('risk_likelihood_id')->nullable();
            $table->foreign('risk_likelihood_id')->references('id')->on('risk_likelihoods')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_risk_assessments');
    }
};
