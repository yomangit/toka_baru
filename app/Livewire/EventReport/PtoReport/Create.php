<?php

namespace App\Livewire\EventReport\PtoReport;

use DateTime;
use App\Models\User;
use App\Models\Company;
use Livewire\Component;
use App\Models\DeptByBU;
use App\Models\Division;
use App\Models\pto_report;
use App\Models\BusinesUnit;
use App\Models\LocationEvent;
use App\Models\RiskAssessment;
use App\Models\RiskLikelihood;
use App\Models\WorkflowDetail;
use App\Models\CompanyCategory;
use App\Models\RiskConsequence;
use App\Models\EventUserSecurity;
use Livewire\Attributes\Validate;
use App\Notifications\toModerator;
use App\Models\TableRiskAssessment;
use Illuminate\Support\Facades\Auth;
use Cjmellor\Approval\Models\Approval;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Notification;

class Create extends Component
{
    public $divider = "PLAN TASK OBSERVATION (PTO) FORM";

    public $reference, $workflow_template_id, $ResponsibleRole;
    public $user, $pto_id, $parent_Company, $workgroup_name, $business_unit, $dept, $division_id, $workflow_detail_id, $select_divisi;
    public $supervisor_area = '';
    // OBSERVER
    #[Validate]
    public $name_observer, $user_id, $job_title, $date_time;
    //TASK BEING OBSERVED
    #[Validate]
    public $task_name, $supervisor_area_id, $location_id, $number_of_worker, $type_of_observation, $scope_of_observation, $job_guidance, $reason_of_observation;
    //TYPE OF ACTIVITIES
    #[Validate]
    public $type_of_activities;
    // OBSERVERVATION CHECKLIST
    #[Validate]
    public $type_of_activities_other, $feedback_for_improvement, $step_of_the_task_in_correct_order, $all_task_steps_are_followed, $worker_qualification, $no_of_worker, $appropriate_ppe, $work_permit_completed, $take5_completed, $pre_job_safety_talk_conductd_properly, $in_good_condition, $used_properly_and_appropriately, $communication_among_worker_properly, $adequate_supervision, $sufficient_time_to_work_safely, $housekeeping_maintained_during_performing_the_task, $job_conducted_safely_as_plan, $still_valid_not_expired_1, $steps_of_the_task_in_correct_order, $all_hazards_identified, $all_hazards_adequately_controlled, $align_with_referred_sop_or_cop, $any_other_effective_work_method, $still_valid_not_expired_2, $specific_and_controlled, $adequately_convered_the_jsea, $still_appropriate_to_current_condition;
    // TABLE
    #[Validate]
    public $risk_consequence_id, $risk_likelihood_id, $risk_assessment_id, $TableRisk = [], $RiskAssessment = [], $tablerisk_id, $risk_probability_doc, $risk_consequence_doc, $risk_likelihood_notes, $risk_probability_id;
    public function changeConditionDivision()
    {
        $this->business_unit = null;
        $this->dept = null;
        $this->select_divisi = null;
        $this->division_id = null;
    }
    public function select_division($id)
    {
        $this->division_id = $id;
    }

    public function parentCompany($id)
    {
        $this->parent_Company = $id;
        $this->business_unit = null;
        $this->dept = null;
        $this->division_id = null;
        $this->workgroup_name = null;
        $this->select_divisi = null;
    }
    public function divisi($id)
    {
        $this->select_divisi = $id;
        $this->parent_Company = null;
        $this->business_unit = null;
        $this->workgroup_name = null;
        $this->dept = null;
        $this->division_id = null;
    }
    public function businessUnit($id)
    {
        $this->business_unit = $id;
        $this->parent_Company = null;
        $this->dept = null;
        $this->division_id = null;
        $this->select_divisi = null;
        $this->workgroup_name = null;
    }
    public function department($id)
    {
        $this->dept = $id;
        $this->parent_Company = null;
        $this->business_unit = null;
        $this->workgroup_name = null;
        $this->division_id = null;
        $this->select_divisi = null;
    }
    public function spvClick(User $user)
    {
        $this->supervisor_area = $user->lookup_name;
        $this->supervisor_area_id = $user->id;
    }
    public function name_observerClick(User $user)
    {
        $this->name_observer = $user->lookup_name;
        $this->user_id = $user->id;
    }

    public function riskId($risk_likelihood_id, $risk_consequence_id, $risk_assessment_id)
    {
        $this->risk_consequence_id = $risk_consequence_id;
        $this->risk_likelihood_id = $risk_likelihood_id;
        $this->risk_assessment_id = $risk_assessment_id;
    }
    public function TableRiskFunction()
    {
        $this->RiskAssessment = TableRiskAssessment::with(['RiskAssessment'])->where('risk_likelihood_id', $this->risk_likelihood_id)->where('risk_consequence_id', $this->risk_consequence_id)->get();
        if ($this->risk_probability_id) {
            $this->risk_probability_doc = RiskConsequence::where('id',  $this->risk_probability_id)->first()->description;
        }
        if ($this->risk_consequence_id) {
            $this->risk_consequence_doc = RiskConsequence::where('id',  $this->risk_consequence_id)->first()->description;
        }
        if ($this->risk_likelihood_id) {
            $this->risk_likelihood_notes = RiskLikelihood::where('id', $this->risk_likelihood_id)->first()->notes;
        }
        if ($this->risk_consequence_id && $this->risk_likelihood_id) {
            $RiskAssessments = TableRiskAssessment::where('risk_likelihood_id', $this->risk_likelihood_id)->where('risk_consequence_id', $this->risk_consequence_id)->first()->risk_assessment_id;

            $this->tablerisk_id = TableRiskAssessment::where('risk_likelihood_id', $this->risk_likelihood_id)->where('risk_consequence_id', $this->risk_consequence_id)->where('risk_assessment_id', $RiskAssessments)->first()->id;
        }
        $this->TableRisk = TableRiskAssessment::with(['RiskAssessment', 'RiskConsequence', 'RiskLikelihood'])->get();
    }
    public function render()
    {
        if (WorkflowDetail::where('workflow_administration_id', $this->workflow_template_id)->exists()) {
            $this->workflow_detail_id = WorkflowDetail::where('workflow_administration_id', $this->workflow_template_id)->first()->id;
            $WorkflowDetail = WorkflowDetail::where('workflow_administration_id', $this->workflow_template_id)->first();
            $this->workflow_detail_id = $WorkflowDetail->id;
            $this->ResponsibleRole = $WorkflowDetail->responsible_role_id;
        }
        if ($this->division_id) {

            $divisi = Division::with(['DeptByBU.BusinesUnit.Company', 'DeptByBU.Department', 'Company', 'Section'])->whereId($this->division_id)->first();

            if (!empty($divisi->company_id) && !empty($divisi->section_id)) {

                $this->workgroup_name =  $divisi->DeptByBU->BusinesUnit->Company->name_company . '-' . $divisi->DeptByBU->Department->department_name . '-' . $divisi->Company->name_company . '-' . $divisi->Section->name;
            } elseif ($divisi->company_id) {
                $this->workgroup_name = $divisi->DeptByBU->BusinesUnit->Company->name_company . '-' . $divisi->DeptByBU->Department->department_name . '-' . $divisi->Company->name_company;
            } elseif ($divisi->section_id) {
                $this->workgroup_name = $divisi->DeptByBU->BusinesUnit->Company->name_company . '-' . $divisi->DeptByBU->Department->department_name . '-' . $divisi->Section->name;
            } else {
                $this->workgroup_name = $divisi->DeptByBU->BusinesUnit->Company->name_company . '-' . $divisi->DeptByBU->Department->department_name;
            }
            $divisi_search = Division::with(['DeptByBU.BusinesUnit.Company', 'DeptByBU.Department', 'Company', 'Section'])->whereId($this->division_id)->searchParent(trim($this->parent_Company))->searchBU(trim($this->business_unit))->searchDept(trim($this->dept))->searchComp(trim($this->select_divisi))->orderBy('dept_by_business_unit_id', 'asc')->get();
        } else {
            $divisi_search = Division::with(['DeptByBU.BusinesUnit.Company', 'DeptByBU.Department', 'Company', 'Section'])->searchDeptCom(trim($this->workgroup_name))->searchParent(trim($this->parent_Company))->searchBU(trim($this->business_unit))->searchDept(trim($this->dept))->searchComp(trim($this->select_divisi))->orderBy('dept_by_business_unit_id', 'asc')->get();
        }
        $this->user = auth()->user()->id;
        $this->TableRiskFunction();
        return view('livewire.event-report.pto-report.create', [
            'Observer' => User::searchNama(trim($this->name_observer))->limit(500)->get(),
            'Supervisor_Area' => User::searchFor(trim($this->supervisor_area))->limit(500)->get(),
            'Location' => LocationEvent::get(),
            'RiskAssessments' => RiskAssessment::get(),
            'RiskConsequence' => RiskConsequence::get(),
            'RiskLikelihood' => RiskLikelihood::get(),
            'Company' => Company::get(),
            'ParentCompany' => CompanyCategory::whereId(1)->get(),
            'BusinessUnit' => BusinesUnit::with(['Department', 'Company'])->get(),
            'Department' => DeptByBU::with(['Department', 'BusinesUnit'])->orderBy('busines_unit_id', 'asc')->get(),
            'Divisi' => Division::whereNotNull('company_id')->with(['DeptByBU.BusinesUnit.Company', 'DeptByBU.Department', 'Company'])->groupBy('company_id')->get(),
            'Division' => $divisi_search,
        ])->extends('base.index', ['header' => 'PTO', 'title' => 'PTO'])->section('content');
    }
    public function rules()
    {

        if ($this->type_of_activities === 'Other activities') {
            return [
                'name_observer' => 'required',
                'user_id' => 'required',
                'supervisor_area_id' => 'required',
                'job_title' => 'required',
                'date_time' => 'required',
                // TASK BEING OBSERVED
                'task_name' => 'required',
                'supervisor_area' => 'required',
                'location_id' => 'required',
                'number_of_worker' => 'required|numeric',
                'type_of_observation' => 'required',
                'scope_of_observation' => 'required',
                'job_guidance' => 'required',
                'reason_of_observation' => 'required',
                // TYPE OF ACTIVITIES
                'type_of_activities' => 'required',
                // OBSERVERVATION CHECKLIST
                'step_of_the_task_in_correct_order' => 'required',
                'all_task_steps_are_followed' => 'required',
                'worker_qualification' => 'required',
                'no_of_worker' => 'required',
                'appropriate_ppe' => 'required',
                'work_permit_completed' => 'required',
                'take5_completed' => 'required',
                'pre_job_safety_talk_conductd_properly' => 'required',
                'in_good_condition' => 'required',
                'used_properly_and_appropriately' => 'required',
                'communication_among_worker_properly' => 'required',
                'adequate_supervision' => 'required',
                'sufficient_time_to_work_safely' => 'required',
                'housekeeping_maintained_during_performing_the_task' => 'required',
                'job_conducted_safely_as_plan' => 'required',
                'still_valid_not_expired_1' => 'required',
                'steps_of_the_task_in_correct_order' => 'required',
                'all_hazards_identified' => 'required',
                'all_hazards_adequately_controlled' => 'required',
                'align_with_referred_sop_or_cop' => 'required',
                'any_other_effective_work_method' => 'required',
                'still_valid_not_expired_2' => 'required',
                'specific_and_controlled' => 'required',
                'adequately_convered_the_jsea' => 'required',
                'still_appropriate_to_current_condition' => 'required',
                'feedback_for_improvement' => 'required',
                // TABLE
                'risk_consequence_id' => 'required',
                'risk_likelihood_id' => 'required',
                'type_of_activities_other' => 'required'
            ];
        } else {
            return [
                'name_observer' => 'required',
                'user_id' => 'required',
                'supervisor_area_id' => 'required',
                'job_title' => 'required',
                'date_time' => 'required',
                // TASK BEING OBSERVED
                'task_name' => 'required',
                'supervisor_area' => 'required',
                'location_id' => 'required',
                'number_of_worker' => 'required|numeric',
                'type_of_observation' => 'required',
                'scope_of_observation' => 'required',
                'job_guidance' => 'required',
                'reason_of_observation' => 'required',
                // TYPE OF ACTIVITIES
                'type_of_activities' => 'required',
                // OBSERVERVATION CHECKLIST
                'step_of_the_task_in_correct_order' => 'required',
                'all_task_steps_are_followed' => 'required',
                'worker_qualification' => 'required',
                'no_of_worker' => 'required',
                'appropriate_ppe' => 'required',
                'work_permit_completed' => 'required',
                'take5_completed' => 'required',
                'pre_job_safety_talk_conductd_properly' => 'required',
                'in_good_condition' => 'required',
                'used_properly_and_appropriately' => 'required',
                'communication_among_worker_properly' => 'required',
                'adequate_supervision' => 'required',
                'sufficient_time_to_work_safely' => 'required',
                'housekeeping_maintained_during_performing_the_task' => 'required',
                'job_conducted_safely_as_plan' => 'required',
                'still_valid_not_expired_1' => 'required',
                'steps_of_the_task_in_correct_order' => 'required',
                'all_hazards_identified' => 'required',
                'all_hazards_adequately_controlled' => 'required',
                'align_with_referred_sop_or_cop' => 'required',
                'any_other_effective_work_method' => 'required',
                'still_valid_not_expired_2' => 'required',
                'specific_and_controlled' => 'required',
                'adequately_convered_the_jsea' => 'required',
                'still_appropriate_to_current_condition' => 'required',
                'feedback_for_improvement' => 'required',
                // TABLE
                'risk_consequence_id' => 'required',
                'risk_likelihood_id' => 'required',
            ];
        }
    }
    public function messages()
    {
        return [
            'risk_likelihood_id.required' => 'The Potential Consequence field is required.',
            'risk_consequence_id.required' => 'The Potential Likelihhod field is required.',
        ];
    }
    public function store()
    {
        $this->validate();
        $source = Approval::whereIn('new_data->reference', [$this->reference])->get();
        foreach ($source as  $value) {
            Approval::find($value->id)->approve();
        }
        if ($this->type_of_activities != "Other activities") {
            $this->type_of_activities_other = null;
        }
        $pto = pto_report::create([
            'name_observer' => $this->name_observer,
            'user_id' => $this->user_id,
            'supervisor_area_id' => $this->supervisor_area_id,
            'job_title' => $this->job_title,
            'date_time' =>  DateTime::createFromFormat('d-m-Y : H:i', $this->date_time)->format('Y-m-d : H:i'),
            'task_name' => $this->task_name,
            'supervisor_area' => $this->supervisor_area,
            'location_id' => $this->location_id,
            'number_of_worker' => $this->number_of_worker,
            'type_of_observation' => $this->type_of_observation,
            'scope_of_observation' => $this->scope_of_observation,
            'job_guidance' => $this->job_guidance,
            'reason_of_observation' => $this->reason_of_observation,
            'type_of_activities' => $this->type_of_activities,
            'step_of_the_task_in_correct_order' => $this->step_of_the_task_in_correct_order,
            'all_task_steps_are_followed' => $this->all_task_steps_are_followed,
            'worker_qualification' => $this->worker_qualification,
            'no_of_worker' => $this->no_of_worker,
            'appropriate_ppe' => $this->appropriate_ppe,
            'work_permit_completed' => $this->work_permit_completed,
            'take5_completed' => $this->take5_completed,
            'pre_job_safety_talk_conductd_properly' => $this->pre_job_safety_talk_conductd_properly,
            'in_good_condition' => $this->in_good_condition,
            'used_properly_and_appropriately' => $this->used_properly_and_appropriately,
            'communication_among_worker_properly' => $this->communication_among_worker_properly,
            'adequate_supervision' => $this->adequate_supervision,
            'sufficient_time_to_work_safely' => $this->sufficient_time_to_work_safely,
            'housekeeping_maintained_during_performing_the_task' => $this->housekeeping_maintained_during_performing_the_task,
            'job_conducted_safely_as_plan' => $this->job_conducted_safely_as_plan,
            'still_valid_not_expired_1' => $this->still_valid_not_expired_1,
            'steps_of_the_task_in_correct_order' => $this->steps_of_the_task_in_correct_order,
            'all_hazards_identified' => $this->all_hazards_identified,
            'all_hazards_adequately_controlled' => $this->all_hazards_adequately_controlled,
            'align_with_referred_sop_or_cop' => $this->align_with_referred_sop_or_cop,
            'any_other_effective_work_method' => $this->any_other_effective_work_method,
            'still_valid_not_expired_2' => $this->still_valid_not_expired_2,
            'specific_and_controlled' => $this->specific_and_controlled,
            'adequately_convered_the_jsea' => $this->adequately_convered_the_jsea,
            'still_appropriate_to_current_condition' => $this->still_appropriate_to_current_condition,
            'feedback_for_improvement' => $this->feedback_for_improvement,
            'risk_consequence_id' => $this->risk_consequence_id,
            'risk_likelihood_id' => $this->risk_likelihood_id,
            'type_of_activities_other' => $this->type_of_activities_other,
            'division_id' =>  $this->division_id,
            'reference' => $this->reference,
            'workflow_template_id' => $this->workflow_template_id,
            'workflow_detail_id' => $this->workflow_detail_id
        ]);

        $this->dispatch(
            'alert',
            [
                'text' => "Data added Successfully!!",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #00b09b, #96c93d)",
            ]
        );
        $getModerator = EventUserSecurity::where('responsible_role_id', $this->ResponsibleRole)->where('user_id', 'not like', Auth::user()->id)->pluck('user_id')->toArray();
        $User = User::whereIn('id', $getModerator)->whereNotNull('email')->get();
        $url = $pto->id;
        foreach ($User as $key => $value) {
            $users = User::whereId($value->id)->get();
            $offerData = [
                'greeting' => 'Dear' . ' ' . $value->lookup_name,
                'subject' => "PTO Report",
                'line' =>  $this->name_observer . ' ' . 'has submitted a PTO report, please review',
                'line2' => 'Please check by click the button below',
                'line3' => 'Thank you',
                'actionUrl' => url("https://tokasafe.archimining.com/eventReport/PTOReport/detail/$url"),

            ];
            Notification::send($users, new toModerator($offerData));
        }
        if ($this->supervisor_area) {
            $Users = User::whereIn('id',  [$this->supervisor_area_id])->whereNotNull('email')->get();
            foreach ($Users as $key => $value) {
                $report_to = User::whereId($value->id)->get();
                $offerData = [
                    'greeting' => 'Dear' . '' . $this->supervisor_area,
                    'subject' => "PTO Report",
                    'line' =>  $this->name_observer . '' . 'has sent a PTO report to you, please review it',
                    'line2' => 'Please check by click the button below',
                    'line3' => 'Thank you',
                    'actionUrl' => url("https://tokasafe.archimining.com/eventReport/PTOReport/detail/$url"),
                ];
                Notification::send($report_to, new toModerator($offerData));
            }
        }
        $this->redirectRoute('ptoDetail', ['id' => $pto->id]);
    }
}
