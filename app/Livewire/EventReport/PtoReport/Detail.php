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
use App\Models\ObserverTeam;
use App\Models\LocationEvent;
use App\Models\ObserverAction;
use App\Models\RiskAssessment;
use App\Models\RiskLikelihood;
use App\Models\CompanyCategory;
use App\Models\RiskConsequence;
use App\Models\EventUserSecurity;
use Livewire\Attributes\Validate;
use App\Models\DocumentationOfPto;
use App\Notifications\toModerator;
use App\Models\TableRiskAssessment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class Detail extends Component
{
    public $divider = "PLAN TASK OBSERVATION (PTO) FORM";
    public $pto_id, $currentStep, $disable_btn, $disable_input, $stepJS, $opacity, $select_divisi, $responsible_role_id;
    // OBSERVER
    #[Validate]
    public $name_observer, $user_id, $job_title, $date_time, $reference, $workflow_template_id, $parent_Company, $workgroup_name, $business_unit, $dept, $division_id, $workflow_detail_id, $division_update;
    //TASK BEING OBSERVED
    #[Validate]
    public $task_name, $supervisor_area_id, $supervisor_area, $location_id, $number_of_worker, $type_of_observation, $scope_of_observation, $job_guidance, $reason_of_observation;
    //TYPE OF ACTIVITIES
    #[Validate]
    public $type_of_activities;
    // OBSERVERVATION CHECKLIST
    #[Validate]
    public $type_of_activities_other, $feedback_for_improvement, $step_of_the_task_in_correct_order, $all_task_steps_are_followed, $worker_qualification, $no_of_worker, $appropriate_ppe, $work_permit_completed, $take5_completed, $pre_job_safety_talk_conductd_properly, $in_good_condition, $used_properly_and_appropriately, $communication_among_worker_properly, $adequate_supervision, $sufficient_time_to_work_safely, $housekeeping_maintained_during_performing_the_task, $job_conducted_safely_as_plan, $still_valid_not_expired_1, $steps_of_the_task_in_correct_order, $all_hazards_identified, $all_hazards_adequately_controlled, $align_with_referred_sop_or_cop, $any_other_effective_work_method, $still_valid_not_expired_2, $specific_and_controlled, $adequately_convered_the_jsea, $still_appropriate_to_current_condition;
    // TABLE
    #[Validate]
    public $risk_consequence_id, $risk_likelihood_id, $risk_assessment_id, $TableRisk = [], $RiskAssessment = [], $tablerisk_id, $risk_probability_doc, $risk_consequence_doc, $risk_likelihood_notes, $risk_probability_id;
    public $assign_to, $also_assign_to;
    protected $listeners = [

        'pto_detail' => 'render',
        'ubahData' => 'changeData'
    ];

    public function mount($id)
    {
        $projectExists = pto_report::whereId($id)->exists();

        if ($projectExists) {
            $projectAkses = pto_report::whereId($id)
                ->Where('user_id', Auth::user()->id)
                ->orWhere('supervisor_area_id', Auth::user()->id)
                ->orWhere('assign_to', Auth::user()->id)
                ->orWhere('also_assign_to', Auth::user()->id);
            if ($projectAkses->exists() || Auth::user()->role_user_permit_id == 1) {
                $this->pto_id = $id;
                $pto_report = pto_report::whereId($id)->first();
                $this->name_observer = $pto_report->name_observer;
                $this->user_id = $pto_report->user_id;
                $this->assign_to = $pto_report->assign_to;
                $this->also_assign_to = $pto_report->also_assign_to;
                $this->supervisor_area_id = $pto_report->supervisor_area_id;
                $this->job_title = $pto_report->job_title;
                $this->date_time = DateTime::createFromFormat('Y-m-d : H:i', $pto_report->date_time)->format('d-m-Y : H:i');
                // TASK BEING OBSERVED
                $this->task_name = $pto_report->task_name;
                $this->supervisor_area = $pto_report->supervisor_area;
                $this->location_id = $pto_report->location_id;
                $this->number_of_worker = $pto_report->number_of_worker;
                $this->type_of_observation = $pto_report->type_of_observation;
                $this->scope_of_observation = $pto_report->scope_of_observation;
                $this->job_guidance = $pto_report->job_guidance;
                $this->reason_of_observation = $pto_report->reason_of_observation;
                // TYPE OF ACTIVITIES
                $this->type_of_activities = $pto_report->type_of_activities;
                // OBSERVERVATION CHECKLIST
                $this->step_of_the_task_in_correct_order = $pto_report->step_of_the_task_in_correct_order;
                $this->all_task_steps_are_followed = $pto_report->all_task_steps_are_followed;
                $this->worker_qualification = $pto_report->worker_qualification;
                $this->no_of_worker = $pto_report->no_of_worker;
                $this->appropriate_ppe = $pto_report->appropriate_ppe;
                $this->work_permit_completed = $pto_report->work_permit_completed;
                $this->take5_completed = $pto_report->take5_completed;
                $this->pre_job_safety_talk_conductd_properly = $pto_report->pre_job_safety_talk_conductd_properly;
                $this->in_good_condition = $pto_report->in_good_condition;
                $this->used_properly_and_appropriately = $pto_report->used_properly_and_appropriately;
                $this->communication_among_worker_properly = $pto_report->communication_among_worker_properly;
                $this->adequate_supervision = $pto_report->adequate_supervision;
                $this->sufficient_time_to_work_safely = $pto_report->sufficient_time_to_work_safely;
                $this->housekeeping_maintained_during_performing_the_task = $pto_report->housekeeping_maintained_during_performing_the_task;
                $this->job_conducted_safely_as_plan = $pto_report->job_conducted_safely_as_plan;
                $this->still_valid_not_expired_1 = $pto_report->still_valid_not_expired_1;
                $this->steps_of_the_task_in_correct_order = $pto_report->steps_of_the_task_in_correct_order;
                $this->all_hazards_identified = $pto_report->all_hazards_identified;
                $this->all_hazards_adequately_controlled = $pto_report->all_hazards_adequately_controlled;
                $this->align_with_referred_sop_or_cop = $pto_report->align_with_referred_sop_or_cop;
                $this->any_other_effective_work_method = $pto_report->any_other_effective_work_method;
                $this->still_valid_not_expired_2 = $pto_report->still_valid_not_expired_2;
                $this->specific_and_controlled = $pto_report->specific_and_controlled;
                $this->adequately_convered_the_jsea = $pto_report->adequately_convered_the_jsea;
                $this->still_appropriate_to_current_condition = $pto_report->still_appropriate_to_current_condition;
                $this->feedback_for_improvement = $pto_report->feedback_for_improvement;
                // TABLE
                $this->risk_consequence_id = $pto_report->risk_consequence_id;
                $this->risk_likelihood_id = $pto_report->risk_likelihood_id;
                $this->type_of_activities_other = $pto_report->type_of_activities_other;
                $this->reference = $pto_report->reference;
                $this->workflow_template_id = $pto_report->workflow_template_id;
                $this->division_id = $pto_report->division_id;
            } else {
                abort(401, 'Unauthorized Access Denied');
            }
        } else {
            abort_unless($projectExists, 404, 'page not found');
        }
    }
    public function changeData()
    {
        $projectExists = pto_report::whereId($this->pto_id)->exists();
        if ($projectExists) {
            $HazardReport = pto_report::SearchId(trim($this->pto_id))->first();
            $this->stepJS = $HazardReport->WorkflowDetails->name;
            $this->dispatch('berhasilUpdate', $this->stepJS);
        } else {
            return redirect()->route('ptoReport');
        }
    }
    public function render()
    {
        $this->updatePanel();
        $this->TableRiskFunction();
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
        return view('livewire.event-report.pto-report.detail', [
            'Observer' => User::searchFor(trim($this->name_observer))->limit(500)->get(),
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
    public function updatePanel()
    {
        $PTO_Report = pto_report::whereId($this->pto_id)->first();
        $this->currentStep = $PTO_Report->WorkflowDetails->name;
        $this->responsible_role_id = $PTO_Report->WorkflowDetails->responsible_role_id;
        $this->assign_to = $PTO_Report->assign_to;
        $this->also_assign_to = $PTO_Report->also_assign_to;
        if ($this->currentStep === 'Closed' || $this->currentStep === 'Cancelled') {
            $this->disable_btn = "cursor-not-allowed";
            $this->disable_input = 1;
            $this->opacity = "opacity-35 bg-gray-500";
        } else {
            $this->reset(['disable_btn', 'disable_input', 'opacity']);
        }
    }
    public function changeConditionDivision()
    {
        $this->business_unit = null;
        $this->dept = null;
        $this->division_id = null;
        $this->select_divisi = null;
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
        $this->workgroup_name = null;
        $this->division_id = null;
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
        $this->workgroup_name = null;
        $this->division_id = null;
        $this->select_divisi = null;
    }
    public function department($id)
    {
        $this->dept = $id;
        $this->parent_Company = null;
        $this->business_unit = null;
        $this->division_id = null;
        $this->workgroup_name = null;
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
    public function rules()
    {

        if ($this->type_of_activities === "Other activities") {
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
        if ($this->type_of_activities != "Other activities") {
            $this->type_of_activities_other = null;
        }

        $pto = pto_report::whereId($this->pto_id)->update([
            'name_observer' => $this->name_observer,
            'user_id' => $this->user_id,
            'supervisor_area_id' => $this->supervisor_area_id,
            'job_title' => $this->job_title,
            'date_time' => DateTime::createFromFormat('d-m-Y : H:i', $this->date_time)->format('Y-m-d : H:i'),
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
            'reference' => $this->reference
        ]);

        $this->dispatch(
            'alert',
            [
                'text' => "Data Updated Successfully!!",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #00b09b, #96c93d)",
            ]
        );
        $url = $this->pto_id;
        if ($this->responsible_role_id == 1) {
            $getModerator = EventUserSecurity::where('responsible_role_id', $this->responsible_role_id)->where('user_id', 'not like', Auth::user()->id)->pluck('user_id')->toArray();
            $User = User::whereIn('id', $getModerator)->whereNotNull('email')->get();

            foreach ($User as $key => $value) {
                $users = User::whereId($value->id)->get();
                $offerData = [
                    'greeting' => 'Dear' . ' ' . $value->lookup_name,
                    'subject' => "PTO Report",
                    'line' =>  Auth::user()->lookup_name . ' ' . 'has update a pto report, please review',
                    'line2' => 'Please check by click the button below',
                    'line3' => 'Thank you',
                    'actionUrl' => url("https://tokasafe.archimining.com/eventReport/PTOReport/detail/$url"),

                ];
                Notification::send($users, new toModerator($offerData));
            }
        }
        if ($this->assign_to) {
            $Users = User::where('id', $this->assign_to)->whereNotNull('email')->get();
            foreach ($Users as $key => $value) {
                $report_to = User::whereId($value->id)->get();
                $offerData = [
                    'greeting' => 'Dear' . '' . $value->lookup_name,
                    'subject' => "PTO Report",
                    'line' =>  Auth::user()->lookup_name . ' ' . 'has update a PTO Report", please review',
                    'line2' => 'Please check by click the button below',
                    'line3' => 'Thank you',
                    'actionUrl' => url("https://tokasafe.archimining.com/eventReport/PTOReport/detail/$url"),
                ];
                Notification::send($report_to, new toModerator($offerData));
            }
        }
        if ($this->also_assign_to) {
            $Users = User::where('id', $this->also_assign_to)->whereNotNull('email')->get();
            foreach ($Users as $key => $value) {
                $report_to = User::whereId($value->id)->get();
                $offerData = [
                    'greeting' => 'Dear' . '' . $value->lookup_name,
                    'subject' => "PTO Report",
                    'line' =>  Auth::user()->lookup_name . ' ' . 'has update a PTO Report", please review',
                    'line2' => 'Please check by click the button below',
                    'line3' => 'Thank you',
                    'actionUrl' => url("https://tokasafe.archimining.com/eventReport/PTOReport/detail/$url"),
                ];
                Notification::send($report_to, new toModerator($offerData));
            }
        }
        if ($this->supervisor_area) {
            $Users = User::whereIn('id',  [$this->supervisor_area_id])->whereNotNull('email')->get();
            foreach ($Users as $key => $value) {
                $report_to = User::whereId($value->id)->get();
                $offerData = [
                    'greeting' => 'Dear' . '' . $value->lookup_name,
                    'subject' => "PTO Report",
                    'line' =>  Auth::user()->lookup_name . ' ' . 'has update a pto report, please review',
                    'line2' => 'Please check by click the button below',
                    'line3' => 'Thank you',
                    'actionUrl' => url("https://tokasafe.archimining.com/eventReport/PTOReport/detail/$url"),
                ];
                Notification::send($report_to, new toModerator($offerData));
            }
        }
        $this->dispatch('panel_pto');
    }
    public function destroy()
    {
        $incidentReport = pto_report::whereId($this->pto_id);

        $files = DocumentationOfPto::where('reference', 'LIKE', $this->reference);
        if (isset($files->first()->name_doc)) {
            unlink(storage_path('app/public/documents/pto/' .   $files->first()->name_doc));
        }
        $incidentReport->delete();
        ObserverTeam::where('reference', 'LIKE', $this->reference)->delete();
        ObserverAction::where('reference', 'LIKE', $this->reference)->delete();

        $this->dispatch(
            'alert',
            [
                'text' => "The Event report was deleted!!",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #ff3333, #ff6666)",
            ]
        );
        return redirect()->route('ptoReport');
    }
}
