<?php

namespace App\Livewire\EventReport\IncidentReport;

use DateTime;
use App\Models\Site;
use App\Models\User;
use App\Models\Company;
use Livewire\Component;
use App\Models\DeptByBU;
use App\Models\Division;
use App\Models\BusinesUnit;
use App\Models\Eventsubtype;
use Livewire\WithPagination;
use App\Models\LocationEvent;
use App\Models\choseEventType;
use App\Models\IncidentReport;
use App\Models\RiskAssessment;
use App\Models\RiskLikelihood;
use App\Models\WorkflowDetail;
use App\Models\CompanyCategory;
use App\Models\RiskConsequence;
use App\Models\TypeEventReport;
use App\Models\EventUserSecurity;
use App\Models\WorkflowApplicable;
use App\Notifications\toModerator;
use App\Models\TableRiskAssessment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Notification;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CreateAndUpdate extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $location_name, $search, $location_id, $divider = 'Input Incident Report', $TableRisk = [], $RiskAssessment = [], $EventSubType = [], $ResponsibleRole, $workflow_template_id, $show = false;
    public $searchLikelihood = '', $searchConsequence = '', $tablerisk_id, $risk_assessment_id, $workflow_detail_id, $reference;
    public $risk_likelihood_id, $risk_likelihood_notes;
    public $risk_consequence_id, $risk_consequence_doc;
    public $workgroup_id, $workgroup_name, $parent_Company, $business_unit, $dept, $division_id, $select_divisi;
    public $search_workgroup = '', $search_report_by = '', $search_report_to = '', $fileUpload;
    public $event_type_id, $sub_event_type_id, $potential_lti,  $report_by, $report_byName, $report_by_nolist, $report_to, $report_toName, $report_to_nolist, $date, $event_location_id, $site_id, $company_involved, $task_being_done, $documentation, $description, $involved_person, $involved_eqipment, $preliminary_cause, $immediate_action_taken, $key_learning;


    public function rules()
    {
        return [
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
            'documentation' => 'nullable|mimes:jpg,jpeg,png,svg,gif,xlsx,pdf,docx',
            'description' => ['required'],
            'involved_person' => ['required'],
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
            'documentation.mimes' => 'Only jpg,jpeg,png,svg,gif,xlsx,pdf,docx file types are allowed',
            'description.required' => 'short description of incident fild is required',
            'involved_person.required' => 'involved person fild is required',
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

    public function changeConditionDivision()
    {
        $this->business_unit = null;
        $this->dept = null;
        $this->select_divisi = null;
        $this->division_id = null;
    }
    public function mount()
    {
        $reportBy = (Auth::user()->lookup_name) ? Auth::user()->lookup_name : Auth::user()->name;
        $this->report_byName = $reportBy;
        $this->report_by = Auth::user()->id;
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

        if (choseEventType::where('route_name', 'LIKE', Request::getPathInfo())->exists()) {
            $eventType = choseEventType::where('route_name', 'LIKE', Request::getPathInfo())->pluck('event_type_id');
            $Event_type = TypeEventReport::whereIn('id', $eventType)->get();
        } else {
            $Event_type = [];
        }
        if (Auth::user()->role_user_permit_id == 1) {
            $this->show = true;
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

        $this->ReportByAndReportTo();
        if ($this->documentation) {
            $file_name = $this->documentation->getClientOriginalName();
            $this->fileUpload = pathinfo($file_name, PATHINFO_EXTENSION);
        }

        if (WorkflowDetail::where('workflow_administration_id', $this->workflow_template_id)->exists()) {
            $WorkflowDetail = WorkflowDetail::where('workflow_administration_id', $this->workflow_template_id)->first();
            $this->workflow_detail_id = $WorkflowDetail->id;
            $this->ResponsibleRole = $WorkflowDetail->responsible_role_id;
        }
        $this->TableRiskFunction();
        $this->EventSubType = (isset($this->event_type_id)) ?  $this->EventSubType = Eventsubtype::where('event_type_id', $this->event_type_id)->get() : [];




        return view('livewire.event-report.incident-report.create-and-update', [
            'RiskAssessments' => RiskAssessment::get(),
            'RiskConsequence' => RiskConsequence::get(),
            'EventType' => $Event_type,
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
            'Location' => LocationEvent::get()

        ])->extends('base.index', ['header' => 'Incident Report', 'title' => 'Incident Report'])->section('content');
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
        $this->workgroup_name = null;
        $this->select_divisi = $id;
        $this->parent_Company = null;
        $this->business_unit = null;
        $this->dept = null;
        $this->division_id = null;
    }
    public function businessUnit($id)
    {
        $this->workgroup_name = null;
        $this->business_unit = $id;
        $this->parent_Company = null;
        $this->dept = null;
        $this->division_id = null;
        $this->select_divisi = null;
    }
    public function department($id)
    {
        $this->workgroup_name = null;
        $this->dept = $id;
        $this->parent_Company = null;
        $this->business_unit = null;
        $this->division_id = null;
        $this->select_divisi = null;
    }

    public function riskId($risk_likelihood_id, $risk_consequence_id, $risk_assessment_id)
    {
        // $this->tablerisk_id = TableRiskAssessment::where('risk_likelihood_id', $risk_likelihood_id)->where('risk_consequence_id', $risk_consequence_id)->where('risk_assessment_id', $risk_assessment_id)->first()->id;
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
        $this->validate();
        if (!empty($this->documentation)) {
            $file_name = $this->documentation->getClientOriginalName();
            $this->fileUpload = pathinfo($file_name, PATHINFO_EXTENSION);
            $this->documentation->storeAs('public/documents/icd', $file_name);
        } else {
            $file_name = "";
        }

        $incident = IncidentReport::exists();
        $referenceIncident = "TT–OHS–ICDN-";
        if (!$incident) {
            $reference = 1;
            $references =  str_pad($reference, 4, "0", STR_PAD_LEFT);
            $this->reference = $referenceIncident . $references;
        } else {
            $incident = IncidentReport::latest()->first();
            $reference = $incident->id + 1;
            $references =  str_pad($reference, 4, "0", STR_PAD_LEFT);
            $this->reference = $referenceIncident . $references;
        }
        $IncidentReport = IncidentReport::create([
            'reference' => $this->reference,
            'event_type_id' => $this->event_type_id,
            'sub_event_type_id' => $this->sub_event_type_id,
            'division_id' => $this->division_id,
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
            'workflow_detail_id' => $this->workflow_detail_id,
            'submitter' => Auth::user()->id
        ]);

        $this->dispatch(
            'alert',
            [
                'text' => "event report has been created",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #06b6d4, #22c55e)",
            ]
        );
        $this->redirectRoute('incidentReportDetail', ['id' => $IncidentReport->id]);


        $getModerator = EventUserSecurity::where('responsible_role_id', $this->ResponsibleRole)->where('user_id', 'not like', Auth::user()->id)->pluck('user_id')->toArray();
        $User = User::whereIn('id', $getModerator)->whereNotNull('email')->get();
        $url = $IncidentReport->id;

        foreach ($User as $key => $value) {
            $users = User::whereId($value->id)->get();
            $offerData = [
                'greeting' => 'Dear' . ' ' . $value->lookup_name,
                'subject' => $this->task_being_done,
                'line' =>  $this->report_byName . ' ' . 'has submitted a hazard report, please review',
                'line2' => 'Please check by click the button below',
                'line3' => 'Thank you',
                'actionUrl' => url("https://tokasafe.archimining.com/eventReport/incidentReportDetail/$url"),

            ];
            Notification::send($users, new toModerator($offerData));
        }
        if ($this->report_toName) {
            $Users = User::whereIn('id',  [$this->report_to])->whereNotNull('email')->get();
            foreach ($Users as $key => $value) {
                $report_to = User::whereId($value->id)->get();
                $offerData = [
                    'greeting' => 'Dear' . '' . $this->report_toName,
                    'subject' => $this->task_being_done,
                    'line' =>  $this->report_byName . '' . 'has sent a hazard report to you, please review it',
                    'line2' => 'Please check by click the button below',
                    'line3' => 'Thank you',
                    'actionUrl' => url("https://tokasafe.archimining.com/eventReport/incidentReportDetail/$url"),
                ];
                Notification::send($report_to, new toModerator($offerData));
            }
        }
    }
}
