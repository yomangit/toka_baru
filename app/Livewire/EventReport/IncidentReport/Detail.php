<?php

namespace App\Livewire\EventReport\IncidentReport;

use DateTime;
use App\Models\Site;
use App\Models\User;
use App\Models\Company;
use Livewire\Component;
use App\Models\DeptByBU;
use App\Models\Division;
use App\Models\EventKeyword;
use App\Models\BusinesUnit;
use Livewire\Attributes\On;
use App\Models\Eventsubtype;
use App\Notifications\toERM;
use Livewire\WithPagination;
use App\Models\LocationEvent;
use Livewire\WithFileUploads;
use App\Models\IncidentReport;
use App\Models\RiskAssessment;
use App\Models\RiskLikelihood;
use App\Models\WorkflowDetail;
use App\Models\CompanyCategory;
use App\Models\EventParticipants;
use App\Models\RiskConsequence;
use App\Models\TypeEventReport;
use App\Models\EventUserSecurity;
use App\Models\WorkflowApplicable;
use App\Notifications\toModerator;
use App\Models\TableRiskAssessment;
use App\Models\IncidentDocumentation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class Detail extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $EventUserSecurity, $assign_to, $also_assign_to, $status, $currentStep, $nameFileDb, $select_divisi;
    public $current_step, $workflow_administration_id, $procced_to, $show = false;
    public $location_name, $search, $location_id, $divider = 'Detail Incident Report', $TableRisk = [], $RiskAssessment = [], $EventSubType = [];
    public $searchLikelihood = '', $searchConsequence = '', $tablerisk_id, $risk_assessment_id, $workflow_detail_id, $reference, $file_doc, $division_id, $parent_Company, $business_unit, $dept, $submitter;
    public $risk_likelihood_id, $risk_likelihood_notes, $description_temp;
    public $risk_consequence_id, $risk_consequence_doc, $immediate_action_taken_temp, $involved_eqipment_temp, $preliminary_cause_temp;
    public $workgroup_id, $workgroup_name, $data_id, $comments, $comment, $key_learning_temp;
    public $search_workgroup = '', $search_report_by = '', $search_report_to = '', $fileUpload, $temp_coment;
    public $event_type_id, $sub_event_type_id, $potential_lti,  $report_by, $report_byName, $report_by_nolist, $responsible_role_id, $report_to, $report_toName, $report_to_nolist, $stepJS, $date, $event_location_id, $site_id, $company_involved, $task_being_done, $documentation, $description, $involved_person, $involved_eqipment, $preliminary_cause, $immediate_action_taken, $key_learning;
    protected $listeners = ['ubahDataIncident' => 'changeData'];
    public function mount($id)
    {
        $projectExists = IncidentReport::whereId($id)->exists();
        $this->data_id = $id;
        if ($projectExists) {

            $projectAkses = IncidentReport::whereId($id)
                ->Where('submitter', Auth::user()->id)
                ->orWhere('report_by', Auth::user()->id)
                ->orWhere('report_to', Auth::user()->id)
                ->orWhere('assign_to', Auth::user()->id)
                ->orWhere('also_assign_to', Auth::user()->id)->exists();
            if (($projectAkses) || (Auth::user()->role_user_permit_id == 1)) {

                $incidentReport = IncidentReport::with(['reportsTo', 'reportBy'])->whereId($id)->first();
                $this->risk_consequence_id = $incidentReport->risk_consequence_id;
                $this->risk_likelihood_id = $incidentReport->risk_likelihood_id;
                $this->reference = $incidentReport->reference;
                $this->status = $incidentReport->WorkflowDetails->Status->status_name;
                $this->workflow_detail_id = $incidentReport->workflow_detail_id;
                $this->current_step = $incidentReport->WorkflowDetails->name;
                $this->event_type_id = $incidentReport->event_type_id;
                $this->sub_event_type_id = $incidentReport->sub_event_type_id;
                $this->potential_lti = $incidentReport->potential_lti;
                $this->report_to_nolist = ($incidentReport->report_to_nolist != null) ? $incidentReport->report_to_nolist : "";
                $this->report_by_nolist = ($incidentReport->report_by_nolist != null) ? $incidentReport->report_by_nolist : "";
                $this->report_toName = ($incidentReport->report_to != null) ? $incidentReport->report_toName :  $this->report_to_nolist;
                $this->report_byName = ($incidentReport->report_by != null) ? $incidentReport->report_byName : $this->report_by_nolist;
                $this->date =  DateTime::createFromFormat('Y-m-d : H:i', $incidentReport->date)->format('d-m-Y : H:i');
                $this->site_id = $incidentReport->site_id;
                $this->task_being_done = $incidentReport->task_being_done;
                $this->description_temp = $incidentReport->description;
                $this->involved_eqipment_temp = $incidentReport->involved_eqipment;
                $this->preliminary_cause_temp = $incidentReport->preliminary_cause;
                $this->immediate_action_taken_temp = $incidentReport->immediate_action_taken;
                $this->key_learning_temp = $incidentReport->key_learning;
                $this->company_involved = $incidentReport->company_involved;
                $this->event_location_id = $incidentReport->event_location_id;
                $this->temp_coment = $incidentReport->comments;
                $this->report_by = $incidentReport->report_by;
                $this->report_to = $incidentReport->report_to;
                $this->submitter = $incidentReport->submitter;
                $this->assign_to = $incidentReport->assign_to;
                $this->also_assign_to = $incidentReport->also_assign_to;
                $this->division_id = $incidentReport->division_id;
            } else {
                abort(401, 'Unauthorized Access Denied');
            }
            $this->ReportByAndReportTo();
        } else {
            abort_unless($projectExists, 404, 'Project not found');
        }
    }


    public function rules()
    {
        return  [
            'event_type_id' => ['required'],
            'sub_event_type_id' => ['required'],
            'potential_lti' => ['required'],
            'workgroup_name' => ['required'],
            'report_byName' => ['required'],
            'report_toName' => ['required'],
            'date' => ['required'],
            'site_id' => ['required'],
            'company_involved' => ['required'],
            'task_being_done' => ['required'],
            'file_doc' => 'nullable|mimes:jpg,jpeg,png,svg,gif,xlsx,pdf,docx',
            'description' => ['required'],
            'involved_eqipment' => ['nullable'],
            'preliminary_cause' => ['required'],
            'event_location_id' => ['required'],
            'immediate_action_taken' => ['required'],
            'key_learning' => ['required'],
            'risk_consequence_id' => ['required'],
            'risk_likelihood_id' => ['required'],
            'report_by_nolist' => ['nullable'],
            'report_to_nolist' => ['nullable'],
        ];
    }
    public function messages()
    {
        return [
            'event_type_id.required' => 'event type fild is required',
            'sub_event_type_id.required' => 'sub event type fild is required',
            'potential_lti.required' => 'potential lti fild is required',
            'report_byName.required' => 'report by fild is required',
            'report_toName.required' => 'report to fild is required',
            'workgroup_name.required' => 'workgroup is required',
            'date.required' => 'date fild is required',
            'site_id.required' => 'site fild is required',
            'company_involved.required' => 'company involved fild is required',
            'task_being_done.required' => 'task being done fild is required',
            'file_doc.mimes' => 'Only jpg,jpeg,png,svg,gif,xlsx,pdf,docx file types are allowed',
            'description.required' => 'short description of incident fild is required',

            'involved_eqipment.required' => 'involved equipment fild is required',
            'preliminary_cause.required' => 'preliminary cause fild is required',
            'event_location_id.required' => 'event location fild is required',
            'immediate_action_taken.required' => 'immediate action fild is required',
            'key_learning.required' => 'key learning fild is required',
            'risk_consequence_id.required' => 'risk consequence fild is required',
            'risk_likelihood_id.required' => 'risk likelihood fild is required',
            'document_id.required' => 'document id fild is required',
            'workgroup_name.required' => 'workgroup name fild is required',
        ];
    }
    public function ReportByAndReportTo()
    {
        if (!empty($this->report_by_nolist)) {
            $this->report_by = null;
            $this->report_byName = $this->report_by_nolist;
        }
        if (!empty($this->report_to_nolist)) {
            $this->report_to = null;
            $this->report_toName = $this->report_to_nolist;
        }
    }
    public function render()
    {

        if ($this->division_id) {

            $divisi = Division::with(['DeptByBU.BusinesUnit.Company', 'DeptByBU.Department', 'Company'])->whereId($this->division_id)->first();
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
        $this->workflow_administration_id = (!empty(WorkflowApplicable::where('type_event_report_id', $this->event_type_id)->first()->workflow_administration_id)) ? WorkflowApplicable::where('type_event_report_id', $this->event_type_id)->first()->workflow_administration_id : null;

        $this->dataUpdate();
        $this->TableRiskFunction();
        $this->EventSubType = (isset($this->event_type_id)) ?  $this->EventSubType = Eventsubtype::where('event_type_id', $this->event_type_id)->get() : [];
        return view('livewire.event-report.incident-report.detail', [
            'RiskAssessments' => RiskAssessment::get(),
            'RiskConsequence' => RiskConsequence::get(),
            'EventType' => TypeEventReport::with('EventCategory')->where('event_category_id', 1)->get(),
            'RiskLikelihood' => RiskLikelihood::get(),
            'Site' => Site::get(),
            'Company' => Company::get(),
            'ParentCompany' => CompanyCategory::whereId(1)->get(),
            'BusinessUnit' => BusinesUnit::with(['Department', 'Company'])->get(),
            'Department' => DeptByBU::with(['Department', 'BusinesUnit'])->orderBy('busines_unit_id', 'asc')->get(),
            'Divisi' => Division::whereNotNull('company_id')->with(['DeptByBU.BusinesUnit.Company', 'DeptByBU.Department', 'Company'])->groupBy('company_id')->get(),
            'Division' => $divisi_search,
            'Report_By' => User::searchNama(trim($this->report_byName))->paginate(100, ['*'], 'Report_By'),
            'Report_To' => User::searchNama(trim($this->report_toName))->paginate(100, ['*'], 'Report_To'),
            'Location' => LocationEvent::get(),
            "Workflow" => WorkflowDetail::where('workflow_administration_id', $this->workflow_administration_id)->where('name', $this->current_step)->get()
        ])->extends('base.index', ['header' => 'Incident Report', 'title' => 'Incident Report', 'id' => $this->data_id])->section('content');
    }
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
        $this->select_divisi = null;
        $this->workgroup_name = null;
    }
    public function divisi($id)
    {
        $this->select_divisi = $id;
        $this->parent_Company = null;
        $this->business_unit = null;
        $this->dept = null;
        $this->division_id = null;
        $this->workgroup_name = null;
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
        $this->division_id = null;
        $this->select_divisi = null;
        $this->workgroup_name = null;
    }

    #[On('panel_incident_realtime')]
    public function dataUpdate()
    {
        $incidentReport = IncidentReport::whereId($this->data_id)->first();
        $fileName = $incidentReport->documentation;
        $this->nameFileDb = $incidentReport->documentation;
        $this->currentStep = $incidentReport->WorkflowDetails->name;
        $this->responsible_role_id = $incidentReport->WorkflowDetails->responsible_role_id;
        if ($this->file_doc) {
            $this->fileUpload = pathinfo($this->file_doc->getClientOriginalName(), PATHINFO_EXTENSION);
            $this->documentation = $this->file_doc->getClientOriginalName();
        } else {
            $this->fileUpload = pathinfo($fileName, PATHINFO_EXTENSION);
            $this->documentation = $fileName;
        }
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
    public function download()
    {
        return response()->download(public_path('storage/documents/icd/' . $this->documentation));
    }
    public function reportedBy($id)
    {
        $this->report_by = $id;
        $ReportBy = User::whereId($id)->first();
        $this->report_byName = $ReportBy->lookup_name;
        $this->report_by_nolist = null;
    }
    public function reportedTo($id)
    {
        $this->report_to = $id;
        $ReportTo = User::whereId($id)->first();
        $this->report_toName = $ReportTo->lookup_name;
        $this->report_to_nolist = null;
    }
    public function store()
    {
        $this->description = (!$this->description) ?   $this->description = $this->description_temp :  $this->description;
        $this->involved_eqipment = (!$this->involved_eqipment) ?   $this->involved_eqipment = $this->involved_eqipment_temp :  $this->involved_eqipment;
        $this->preliminary_cause = (!$this->preliminary_cause) ?   $this->preliminary_cause = $this->preliminary_cause_temp :  $this->preliminary_cause;
        $this->immediate_action_taken = (!$this->immediate_action_taken) ?   $this->immediate_action_taken = $this->immediate_action_taken_temp :  $this->immediate_action_taken;
        $this->key_learning = (!$this->key_learning) ?   $this->key_learning = $this->key_learning_temp : $this->key_learning;
        $this->comments = (!$this->comment) ?   $this->comments = $this->temp_coment :  $this->comment;
        $this->validate();
        if (!empty($this->file_doc)) {
            $file_name = $this->file_doc->getClientOriginalName();
            $this->fileUpload = pathinfo($file_name, PATHINFO_EXTENSION);
            $this->file_doc->storeAs('public/documents/icd', $file_name);
        }
        IncidentReport::whereId($this->data_id)->update([
            'event_type_id' => $this->event_type_id,
            'sub_event_type_id' => $this->sub_event_type_id,
            'division_id' =>  $this->division_id,
            'report_by' => $this->report_by,
            'report_to' => $this->report_to,
            'site_id' => $this->site_id,
            'company_involved' => $this->company_involved,
            'risk_consequence_id' => $this->risk_consequence_id,
            'risk_likelihood_id' => $this->risk_likelihood_id,
            'event_location_id' => $this->event_location_id,
            'workgroup_name' => $this->workgroup_name,
            'potential_lti' => $this->potential_lti,
            'report_byName' => $this->report_byName,
            'report_toName' => $this->report_toName,
            'date' => DateTime::createFromFormat('d-m-Y : H:i', $this->date)->format('Y-m-d : H:i'),
            'task_being_done' => $this->task_being_done,
            'documentation' => $this->documentation,
            'description' => $this->description,
            'involved_eqipment' => $this->involved_eqipment,
            'preliminary_cause' => $this->preliminary_cause,
            'immediate_action_taken' => $this->immediate_action_taken,
            'key_learning' => $this->key_learning,
            'report_by_nolist' => $this->report_to_nolist,
            'report_to_nolist' => $this->report_to_nolist,
            'comments' => $this->comments,
            'submitter' => $this->submitter,
        ]);

        // Notification
        if ($this->responsible_role_id = 1) {
            $getModerator = EventUserSecurity::where('responsible_role_id', $this->responsible_role_id)->where('user_id', 'NOT LIKE', Auth::user()->id)->pluck('user_id')->toArray();
            $User = User::whereIn('id', $getModerator)->get();
            $url = $this->data_id;
            foreach ($User as $key => $value) {
                $users = User::whereId($value->id)->get();
                $offerData = [
                    'greeting' => $value->lookup_name,
                    'subject' => $this->task_being_done,
                    'line' =>  $value->lookup_name . ' ' . 'has update a hazard report, please review',
                    'line2' => 'Please review this report',
                    'line3' => 'Thank you',
                    'actionUrl' => url("https://tokasafe.archimining.com/eventReport/incidentReportDetail/$url"),
                ];
                Notification::send($users, new toModerator($offerData));
            }
        }
        if ($this->assign_to) {
            $Users = User::where('id', $this->assign_to)->whereNotNull('email')->get();
            foreach ($Users as $key => $value) {
                $report_to = User::whereId($value->id)->get();
                $offerData = [
                    'greeting' => 'Dear' . '' . $this->report_toName,
                    'subject' => $this->task_being_done,
                    'line' =>  $value->lookup_name . ' ' . 'has update a hazard report, please review',
                    'line2' => 'Please check by click the button below',
                    'line3' => 'Thank you',
                    'actionUrl' => url("https://tokasafe.archimining.com/eventReport/incidentReportDetail/$url"),
                ];
                Notification::send($report_to, new toModerator($offerData));
            }
        }
        if ($this->also_assign_to) {
            $Users = User::where('id', $this->also_assign_to)->whereNotNull('email')->get();
            foreach ($Users as $key => $value) {
                $report_to = User::whereId($value->id)->get();
                $offerData = [
                    'greeting' => 'Dear' . '' . $this->report_toName,
                    'subject' => $this->task_being_done,
                    'line' =>  Auth::user()->lookup_name . ' ' . 'has update a hazard report, please review',
                    'line2' => 'Please check by click the button below',
                    'line3' => 'Thank you',
                    'actionUrl' => url("https://tokasafe.archimining.com/eventReport/incidentReportDetail/$url"),
                ];
                Notification::send($report_to, new toModerator($offerData));
            }
        }
        $Users = User::where('id', $this->report_to)->whereNotNull('email')->get();
        foreach ($Users as $key => $value) {
            $report_to = User::whereId($value->id)->get();
            $offerData = [
                'greeting' => 'Dear' . '' . $this->report_toName,
                'subject' => $this->task_being_done,
                'line' =>  Auth::user()->lookup_name . ' ' . 'has update a hazard report, please review',
                'line2' => 'Please check by click the button below',
                'line3' => 'Thank you',
                'actionUrl' => url("https://tokasafe.archimining.com/eventReport/incidentReportDetail/$url"),
            ];
            Notification::send($report_to, new toModerator($offerData));
        }

        $this->dispatch(
            'alert',
            [
                'text' => "this record has been updated!!",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #06b6d4, #22c55e)",
            ]
        );
    }

    public function destroy()
    {
        $incidentReport = IncidentReport::whereId($this->data_id);

        $files = IncidentDocumentation::where('incident_id', $this->data_id);
        if (isset($files->first()->name_doc)) {
            unlink(storage_path('app/public/documents/incident/' .   $files->first()->name_doc));
        }
        $incidentReport->delete();
        EventParticipants::where('reference', $this->reference)->delete();
        EventKeyword::where('reference', $this->reference)->delete();
        return redirect()->route('incidentReport');
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
    }
    public function changeData()
    {
        $projectExists = IncidentReport::whereId($this->data_id)->exists();
        if ($projectExists) {
            $HazardReport = IncidentReport::whereId($this->data_id)->first();
            $this->stepJS = $HazardReport->WorkflowDetails->name;
            $this->dispatch('berhasilUpdateIncident', $this->stepJS);
        } else {
            return redirect()->route('incidentReport');
        }
    }
}
