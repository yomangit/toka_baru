<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class pto_report extends Model
{
    use HasFactory;
    protected $table = 'pto_report';
    protected $fillable = [
        'name_observer',
        'user_id',
        'supervisor_area_id',
        'job_title',
        'date_time',
        'task_name',
        'supervisor_area',
        'location_id',
        'number_of_worker',
        'type_of_observation',
        'scope_of_observation',
        'job_guidance',
        'reason_of_observation',
        'type_of_activities',
        'step_of_the_task_in_correct_order',
        'all_task_steps_are_followed',
        'worker_qualification',
        'no_of_worker',
        'appropriate_ppe',
        'work_permit_completed',
        'take5_completed',
        'pre_job_safety_talk_conductd_properly',
        'in_good_condition',
        'used_properly_and_appropriately',
        'communication_among_worker_properly',
        'adequate_supervision',
        'sufficient_time_to_work_safely',
        'housekeeping_maintained_during_performing_the_task',
        'job_conducted_safely_as_plan',
        'still_valid_not_expired_1',
        'steps_of_the_task_in_correct_order',
        'all_hazards_identified',
        'all_hazards_adequately_controlled',
        'align_with_referred_sop_or_cop',
        'any_other_effective_work_method',
        'still_valid_not_expired_2',
        'specific_and_controlled',
        'adequately_convered_the_jsea',
        'still_appropriate_to_current_condition',
        'feedback_for_improvement',
        'risk_consequence_id',
        'risk_likelihood_id',
        'type_of_activities_other',
        'reference',
        'workflow_template_id',
        'workflow_detail_id',
        'division_id'
    ];
    public function WorkflowDetails()
    {
        return $this->belongsTo(WorkflowDetail::class, 'workflow_detail_id');
    }
    public function scopeSearchId($q, $term)
    {
        $q->when(
            $term ?? false,
            fn($q, $term) => $q->where('id', $term)
        );
    }
    public function scopeSearchMonth($q, $term)
    {
        $q->when(
            $term ?? false,
            fn($q, $term) => $q->where('date_time', 'like', '%' . $term . '%')
        );
    }
   
}
