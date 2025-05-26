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
        Schema::create('hazard_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_type_id')->nullable();
            $table->foreign('event_type_id')->references('id')->on('type_event_reports')->onDelete('cascade');
            $table->unsignedBigInteger('sub_event_type_id')->nullable();
            $table->foreign('sub_event_type_id')->references('id')->on('eventsubtypes')->onDelete('cascade');
            $table->unsignedBigInteger('division_id')->nullable();
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
            $table->unsignedBigInteger('report_by')->nullable();
            $table->foreign('report_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('report_to')->nullable();
            $table->foreign('report_to')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('site_id')->nullable();
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            $table->unsignedBigInteger('company_involved')->nullable();
            $table->foreign('company_involved')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('risk_consequence_id')->nullable();
            $table->foreign('risk_consequence_id')->references('id')->on('risk_consequences')->onDelete('cascade');
            $table->unsignedBigInteger('risk_likelihood_id')->nullable();
            $table->foreign('risk_likelihood_id')->references('id')->on('risk_likelihoods')->onDelete('cascade');
            $table->unsignedBigInteger('risk_probability_id')->nullable();
            $table->foreign('risk_probability_id')->references('id')->on('risk_consequences')->onDelete('cascade');
            $table->unsignedBigInteger('event_location_id')->nullable();
            $table->foreign('event_location_id')->references('id')->on('location_events')->onDelete('cascade');
            $table->unsignedBigInteger('workflow_detail_id')->nullable();
            $table->foreign('workflow_detail_id')->references('id')->on('workflow_details')->onDelete('cascade');
            $table->unsignedBigInteger('assign_to')->nullable();
            $table->foreign('assign_to')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('also_assign_to')->nullable();
            $table->foreign('also_assign_to')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('submitter')->nullable();
            $table->foreign('submitter')->references('id')->on('users')->onDelete('cascade');
            $table->string('workgroup_name')->nullable();
            $table->string('report_byName')->nullable();
            $table->string('report_toName')->nullable();
            $table->string('reference')->nullable();
            $table->string('date')->nullable();
            $table->string('task_being_done')->nullable();
            $table->string('documentation')->nullable();
            $table->text('description')->nullable();
            $table->text('immediate_corrective_action')->nullable();
            $table->text('suggested_corrective_action')->nullable();
            $table->text('corrective_action_suggested')->nullable();
            $table->string('report_by_nolist')->nullable();
            $table->string('report_to_nolist')->nullable();
            $table->string('moderator')->nullable();
            $table->string('status')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hazard_reports');
    }
};
