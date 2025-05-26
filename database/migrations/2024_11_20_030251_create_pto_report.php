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
        Schema::create('pto_report', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->string('name_observer')->nullable();;
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('job_title')->nullable();;
            $table->string('date_time')->nullable();;
            // TASK BEING OBSERVED
            $table->string('task_name')->nullable();;
            $table->string('supervisor_area')->nullable();;
            $table->unsignedBigInteger('supervisor_area_id')->nullable();
            $table->foreign('supervisor_area_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('location_id')->nullable();;
            $table->string('number_of_worker')->nullable();;
            $table->string('type_of_observation')->nullable();;
            $table->string('scope_of_observation')->nullable();;
            $table->string('job_guidance')->nullable();;
            $table->string('reason_of_observation')->nullable();;
            // TYPE OF ACTIVITIES
            $table->string('type_of_activities')->nullable();;
            // OBSERVERVATION CHECKLIST
            $table->string('step_of_the_task_in_correct_order')->nullable();;
            $table->string('all_task_steps_are_followed')->nullable();;
            $table->string('worker_qualification')->nullable();;
            $table->string('no_of_worker')->nullable();;
            $table->string('appropriate_ppe')->nullable();;
            $table->string('work_permit_completed')->nullable();;
            $table->string('take5_completed')->nullable();;
            $table->string('pre_job_safety_talk_conductd_properly')->nullable();;
            $table->string('in_good_condition')->nullable();;
            $table->string('used_properly_and_appropriately')->nullable();;
            $table->string('communication_among_worker_properly')->nullable();;
            $table->string('adequate_supervision')->nullable();;
            $table->string('sufficient_time_to_work_safely')->nullable();;
            $table->string('housekeeping_maintained_during_performing_the_task')->nullable();;
            $table->string('job_conducted_safely_as_plan')->nullable();;
            $table->string('still_valid_not_expired_1')->nullable();;
            $table->string('steps_of_the_task_in_correct_order')->nullable();;
            $table->string('all_hazards_identified')->nullable();;
            $table->string('all_hazards_adequately_controlled')->nullable();;
            $table->string('align_with_referred_sop_or_cop')->nullable();;
            $table->string('any_other_effective_work_method')->nullable();;
            $table->string('still_valid_not_expired_2')->nullable();;
            $table->string('specific_and_controlled')->nullable();;
            $table->string('adequately_convered_the_jsea')->nullable();;
            $table->string('still_appropriate_to_current_condition')->nullable();;
            $table->text('feedback_for_improvement')->nullable();;
            // TABLE
            $table->unsignedBigInteger('risk_consequence_id')->nullable();
            $table->foreign('risk_consequence_id')->references('id')->on('risk_consequences')->onDelete('cascade');
            $table->unsignedBigInteger('risk_likelihood_id')->nullable();
            $table->foreign('risk_likelihood_id')->references('id')->on('risk_likelihoods')->onDelete('cascade');
            $table->string('type_of_activities_other')->nullable();
            $table->unsignedBigInteger('workflow_detail_id')->nullable();
            $table->foreign('workflow_detail_id')->references('id')->on('workflow_details')->onDelete('cascade');
            $table->unsignedBigInteger('assign_to')->nullable();
            $table->foreign('assign_to')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('also_assign_to')->nullable();
            $table->foreign('also_assign_to')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('division_id')->nullable();
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
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
        Schema::dropIfExists('pto_report');
    }
};
