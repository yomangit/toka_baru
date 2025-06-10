<?php

namespace App\Livewire\EventReport\HazardReport;

use DateTime;
use App\Models\Site;
use App\Models\User;
use App\Models\Company;
use Livewire\Component;
use App\Models\DeptByBU;
use App\Models\Division;
use App\Models\BusinesUnit;
use App\Models\Eventsubtype;
use App\Models\HazardReport;
use Livewire\WithPagination;
use App\Models\LocationEvent;
use Livewire\WithFileUploads;
use App\Models\choseEventType;
use App\Models\RiskAssessment;
use App\Models\RiskLikelihood;
use App\Models\CompanyCategory;
use App\Models\RiskConsequence;
use App\Models\TypeEventReport;
use App\Models\EventParticipants;
use App\Models\EventUserSecurity;
use App\Models\WorkflowApplicable;
use App\Notifications\toModerator;
use App\Models\HazardDocumentation;
use App\Models\TableRiskAssessment;
use App\Notifications\toERM;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class Detail extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $immediate_corrective_action_temp;
    public $suggested_corrective_action_temp;
    public $corrective_action_suggested_temp;
    public $comment_temp;
    public $description_temp;
    public $location_name, $search, $show_immidiate = 'yes', $procced_to, $location_id, $divider = 'Details Hazard Report', $TableRisk = [], $RiskAssessment = [], $EventSubType = [], $ResponsibleRole, $EventUserSecurity = [];
    public $searchLikelihood = '', $searchConsequence = '', $tablerisk_id, $risk_assessment_id, $reference, $workflow_detail_id, $division_id, $division, $parent_Company, $business_unit, $dept;
    public $risk_likelihood_id, $risk_likelihood_notes, $event_category, $select_divisi;
    public $risk_consequence_id, $risk_consequence_doc, $risk_probability_doc;
    public $workgroup_id, $workgroup_name,  $assign_to, $also_assign_to, $comment = '', $workflow_administration_id, $responsible_role_id, $show = false;
    public $search_workgroup = '', $search_report_by = '', $search_report_to = '', $fileUpload, $file_doc, $status, $data_id, $step, $stepJS = [], $currentStep, $nameFileDb;
    public $event_type_id, $sub_event_type_id,  $report_by, $report_byName, $submitter, $report_by_nolist, $report_to, $report_toName, $report_to_nolist, $date, $event_location_id, $site_id, $company_involved, $task_being_done, $documentation, $description, $immediate_corrective_action, $suggested_corrective_action, $corrective_action_suggested;
    public $dropdownLocation = 'dropdown', $hidden = 'block';
    public $dropdownWorkgroup = 'dropdown', $hiddenWorkgroup = 'block';
    public $dropdownReportBy = 'dropdown', $hiddenReportBy = 'block', $hiddenReportTo = 'block', $kondisi_tidak_aman, $tindakkan_selanjutnya;
    protected $listeners = ['ubahData' => 'changeData'];
    public function mount($id)
    {
        $projectExists = HazardReport::whereId($id)->exists();

        if ($projectExists) {
            $this->data_id = $id;
            $projectAkses = HazardReport::whereId($id)
                ->Where('submitter', Auth::user()->id)
                ->orWhere('report_by', Auth::user()->id)
                ->orWhere('report_to', Auth::user()->id)
                ->orWhere('assign_to', Auth::user()->id)
                ->orWhere('also_assign_to', Auth::user()->id);
            if ($projectAkses->exists() || Auth::user()->role_user_permit_id == 1) {
                $HazardReport = HazardReport::whereId($this->data_id)->first();
                $this->risk_consequence_id = $HazardReport->risk_consequence_id;
                $this->risk_likelihood_id = $HazardReport->risk_likelihood_id;
                $this->report_by = $HazardReport->report_by;
                $this->report_to = $HazardReport->report_to;
                $this->submitter = $HazardReport->submitter;
                $this->assign_to = $HazardReport->assign_to;
                $this->kondisi_tidak_aman = $HazardReport->kondisi_tidak_aman;
                $this->tindakkan_selanjutnya = $HazardReport->tindakkan_selanjutnya;
                $this->also_assign_to = $HazardReport->also_assign_to;
                $this->division_id = $HazardReport->division_id;
                $this->reference = $HazardReport->reference;
                $this->workflow_detail_id = $HazardReport->workflow_detail_id;
                $this->event_type_id = $HazardReport->event_type_id;
                $this->event_category = ($this->event_type_id == null) ? "" : $HazardReport->eventType->event_category_id;
                $this->sub_event_type_id = $HazardReport->sub_event_type_id;
                $this->report_toName = ($HazardReport->report_to) ? $HazardReport->reportsTo->lookup_name : $HazardReport->report_toName;
                $this->report_byName = ($HazardReport->report_by) ? $HazardReport->reportBy->lookup_name : $HazardReport->report_byName;
                $this->report_to_nolist = ($HazardReport->report_to_nolist) ? $HazardReport->report_to_nolist : "";
                $this->report_by_nolist = ($HazardReport->report_by_nolist) ? $HazardReport->report_by_nolist : "";
                $this->date = DateTime::createFromFormat('Y-m-d : H:i', $HazardReport->date)->format('d-m-Y : H:i');
                // $this->site_id = $HazardReport->site_id;
                $this->task_being_done = $HazardReport->task_being_done;
                $this->description_temp = $HazardReport->description;
                $this->immediate_corrective_action_temp = $HazardReport->immediate_corrective_action;
                $this->suggested_corrective_action_temp = $HazardReport->suggested_corrective_action;
                $this->corrective_action_suggested_temp = $HazardReport->corrective_action_suggested;

                $this->company_involved = $HazardReport->company_involved;
                $this->location_name = $HazardReport->location_name;
                $this->comment_temp = $HazardReport->comment;
            } else {
                abort(401, 'Unauthorized Access Denied');
            }
            $this->ReportByAndReportTo();
        } else {
            abort_unless($projectExists, 404, 'page not found');
        }
    }


    public function rules()
    {
        if ($this->show_immidiate === 'yes') {

            return [
                'event_type_id' => ['required'],
                'sub_event_type_id' => ['required'],
                'workgroup_name' => ['required'],
                'report_byName' => ['required'],
                'report_toName' => ['required'],
                'date' => ['required'],
                'site_id' => ['nullable'],
                'file_doc' => 'nullable|mimes:jpg,jpeg,png,svg,gif,xlsx,pdf,docx',
                'description' => ['required'],
                'immediate_corrective_action' => ['required'],
                'location_name' => ['required'],
                'risk_consequence_id' => ['required'],
                'risk_likelihood_id' => ['required'],
                'report_by_nolist' => ['nullable'],
                'comment' => ['nullable'],
            ];
        } else {
            return [
                'event_type_id' => ['required'],
                'sub_event_type_id' => ['required'],
                'workgroup_name' => ['required'],
                'report_byName' => ['required'],
                'report_toName' => ['required'],
                'date' => ['required'],
                'site_id' => ['nullable'],
                'file_doc' => 'nullable|mimes:jpg,jpeg,png,svg,gif,xlsx,pdf,docx',
                'description' => ['required'],
                'immediate_corrective_action' => ['nullable'],
                'location_name' => ['required'],
                'risk_consequence_id' => ['required'],
                'risk_likelihood_id' => ['required'],
                'report_by_nolist' => ['nullable'],
                'comment' => ['nullable'],
            ];
        }
    }
    public function messages()
    {
        return [
            'event_type_id.required' => 'event type fild is required',
            'sub_event_type_id.required' => 'sub event type fild is required',
            'report_byName.required' => 'report by fild is required',
            'report_toName.required' => 'report to fild is required',
            'workgroup_name.required' => 'responsibility workgroup is required',
            'date.required' => 'date fild is required',
            'site_id.required' => 'site fild is required',
            'company_involved.required' => 'company involved fild is required',
            'task_being_done.required' => 'task being done fild is required',
            'file_doc.mimes' => 'Only jpg,jpeg,png,svg,gif,xlsx,pdf,docx file types are allowed',
            'description.required' => 'hazard details fild is required',
            'immediate_corrective_action.required' => 'immediate corrective action fild is required',
            'suggested_corrective_action.required' => 'involved equipment fild is required',
            'location_name.required' => 'event location fild is required',
            'corrective_action_suggested.required' => 'corrective action suggested fild is required',
            'risk_consequence_id.required' => 'potential consequence fild is required',
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
        if (choseEventType::where('route_name', 'LIKE', '%' . '/eventReport/hazardReport' . '%')->exists()) {
            $eventType = choseEventType::where('route_name', 'LIKE', '%' . '/eventReport/hazardReport' . '%')->pluck('event_type_id');
            $Event_type = TypeEventReport::whereIn('id', $eventType)->get();
        } else {
            $Event_type = [];
        }
        $this->dataUpdate();
        $this->workflow_administration_id = (!empty(WorkflowApplicable::where('type_event_report_id', $this->event_type_id)->first()->workflow_administration_id)) ? WorkflowApplicable::where('type_event_report_id', $this->event_type_id)->first()->workflow_administration_id : null;

        if ($this->division_id) {

            $divisi = Division::with(['DeptByBU.BusinesUnit.Company', 'DeptByBU.Department', 'Company', 'Section'])->whereId($this->division_id)->first();
            if (!empty($divisi->company_id) && !empty($divisi->section_id)) {
                $this->workgroup_name =   $divisi->DeptByBU->Department->department_name . '-' . $divisi->Company->name_company . '-' . $divisi->Section->name;
            } elseif ($divisi->company_id) {
                $this->workgroup_name =  $divisi->DeptByBU->Department->department_name . '-' . $divisi->Company->name_company;
            } elseif ($divisi->section_id) {
                $this->workgroup_name =  $divisi->DeptByBU->Department->department_name . '-' . $divisi->Section->name;
            } else {
                $this->workgroup_name =  $divisi->DeptByBU->Department->department_name;
            }
            $divisi_search = Division::with(['DeptByBU.BusinesUnit.Company', 'DeptByBU.Department', 'Company', 'Section'])->whereId($this->division_id)->searchParent(trim($this->parent_Company))->searchBU(trim($this->business_unit))->searchDept(trim($this->dept))->searchComp(trim($this->select_divisi))->orderBy('dept_by_business_unit_id', 'asc')->get();
        } else {
            $divisi_search = Division::with(['DeptByBU.BusinesUnit.Company', 'DeptByBU.Department', 'Company', 'Section'])->searchDeptCom(trim($this->workgroup_name))->searchParent(trim($this->parent_Company))->searchBU(trim($this->business_unit))->searchDept(trim($this->dept))->searchComp(trim($this->select_divisi))->orderBy('dept_by_business_unit_id', 'asc')->get();
        }
        $this->TableRiskFunction();
        $this->EventSubType = (isset($this->event_type_id)) ?  $this->EventSubType = Eventsubtype::where('event_type_id', $this->event_type_id)->get() : [];
        return view('livewire.event-report.hazard-report.detail', [
            'RiskAssessments' => RiskAssessment::get(),
            'RiskConsequence' => RiskConsequence::get(),
            'EventType' =>  $Event_type,
            'RiskLikelihood' => RiskLikelihood::get(),
            'Site' => Site::get(),
            'Company' => Company::get(),
            'ParentCompany' => CompanyCategory::whereId(1)->get(),
            'BusinessUnit' => BusinesUnit::with(['Department', 'Company'])->get(),
            'Department' => DeptByBU::with(['Department', 'BusinesUnit'])->orderBy('busines_unit_id', 'asc')->get(),
            'Divisi' => Division::whereNotNull('company_id')->with(['DeptByBU.BusinesUnit.Company', 'DeptByBU.Department', 'Company'])->groupBy('company_id')->get(),
            'Division' => $divisi_search,
            'Report_By' => User::searchFor(trim($this->report_byName))->paginate(100, ['*'], 'Report_By'),
            'Report_To' => User::searchFor(trim($this->report_toName))->paginate(100, ['*'], 'Report_To'),
            'Location' => LocationEvent::get(),
        ])->extends('base.index', ['header' => 'Hazard Report', 'title' => 'Hazard Report', 'id' => $this->data_id])->section('content');
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
        $this->hiddenWorkgroup = 'hidden';
        $this->hiddenReportBy = 'hidden';
        $this->hiddenReportTo = 'hidden';
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
        $this->workgroup_name = null;
        $this->business_unit = null;
        $this->dept = null;
        $this->division_id = null;
    }
    public function businessUnit($id)
    {
        $this->business_unit = $id;
        $this->parent_Company = null;
        $this->workgroup_name = null;
        $this->dept = null;
        $this->division_id = null;
        $this->select_divisi = null;
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
    public function clickReportBy()
    {
        $this->hiddenReportBy = 'block';
    }
    public function clickReportTo()
    {
        $this->hiddenReportTo = 'block';
    }
    public function clickWorkgroup()
    {
        $this->hiddenWorkgroup = 'block';
    }
    public function dataUpdate()
    {
        $HazardReport = HazardReport::whereId($this->data_id)->first();
        $fileName = $HazardReport->documentation;
        $this->nameFileDb = $HazardReport->documentation;
        $this->currentStep = $HazardReport->WorkflowDetails->name;
        $this->responsible_role_id = $HazardReport->WorkflowDetails->responsible_role_id;
        $this->assign_to = $HazardReport->assign_to;
        $this->also_assign_to = $HazardReport->also_assign_to;
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
        return response()->download(public_path('/storage/documents/hzd/' . $this->documentation));
    }
    public function reportedBy($id)
    {
        $this->report_by = $id;
        $ReportBy = User::whereId($id)->first();
        $this->report_byName = $ReportBy->lookup_name;
        $this->report_by_nolist = null;
        $this->hiddenReportBy = 'hidden';
    }
    public function reportedTo($id)
    {
        $this->report_to = $id;
        $ReportTo = User::whereId($id)->first();
        $this->report_toName = $ReportTo->lookup_name;
        $this->report_to_nolist = null;
        $this->hiddenReportTo = 'hidden';
    }
    public function store()
    {
        $this->description = (!$this->description) ?   $this->description = $this->description_temp :  $this->description;
        $this->immediate_corrective_action = (!$this->immediate_corrective_action) ?   $this->immediate_corrective_action = $this->immediate_corrective_action_temp :  $this->immediate_corrective_action;
        $this->comment = (!$this->comment) ?   $this->comment = $this->comment_temp :  $this->comment;
        $this->validate();
        if (!empty($this->file_doc)) {
            $file_name = $this->file_doc->getClientOriginalName();
            $this->fileUpload = pathinfo($file_name, PATHINFO_EXTENSION);
            $this->file_doc->storeAs('public/documents/hzd', $file_name);
        }
        if ($this->show_immidiate === 'no') {
            $this->immediate_corrective_action = null;
        }
        HazardReport::whereId($this->data_id)->update([
            'reference' => $this->reference,
            'event_type_id' => $this->event_type_id,
            'sub_event_type_id' => $this->sub_event_type_id,
            'division_id' =>  $this->division_id,
            'report_by' => $this->report_by,
            'report_to' => $this->report_to,
            // 'site_id' => $this->site_id,
            'risk_consequence_id' => $this->risk_consequence_id,
            'risk_likelihood_id' => $this->risk_likelihood_id,
            'location_name' => $this->location_name,
            'workgroup_name' => $this->workgroup_name,
            'report_byName' => $this->report_byName,
            'report_toName' => $this->report_toName,
            'date' => DateTime::createFromFormat('d-m-Y : H:i', $this->date)->format('Y-m-d : H:i'),
            'documentation' =>   $this->documentation,
            'description' => $this->description,
            'kondisi_tidak_aman' => $this->kondisi_tidak_aman,
            'tindakkan_selanjutnya' => $this->tindakkan_selanjutnya,
            'immediate_corrective_action' => $this->immediate_corrective_action,
            'report_by_nolist' => $this->report_to_nolist,
            'report_to_nolist' => $this->report_to_nolist,
            'workflow_detail_id' => $this->workflow_detail_id,
            'submitter' => $this->submitter,
            'comment' => $this->comment,
            'show_immidiate' => $this->show_immidiate
        ]);
        $this->dispatch(
            'alert',
            [
                'text' => "event report has been updated",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #06b6d4, #22c55e)",
            ]
        );
        // Notification
        if ($this->responsible_role_id = 1) {
            $getModerator = EventUserSecurity::where('responsible_role_id', $this->responsible_role_id)->where('user_id', 'NOT LIKE', Auth::user()->id)->pluck('user_id')->toArray();
            $User = User::whereIn('id', $getModerator)->get();
            $url = $this->data_id;
            foreach ($User as $key => $value) {
                $users = User::whereId($value->id)->get();
                $offerData = [
                    'greeting' => 'Hi' . '' .   $value->lookup_name,
                    'subject' => 'Hazard Report' . ' ' . $this->reference,
                    'line' =>  Auth::user()->lookup_name . ' ' . 'has update a hazard report, please review',
                    'line2' => 'Please review this report',
                    'line3' => 'Thank you',
                    'actionUrl' => url("/eventReport/hazardReportDetail/$url"),
                ];
                Notification::send($users, new toModerator($offerData));
            }
        }


        $this->dispatch('hzrd_updated', $this->data_id);
    }
    public function destroy()
    {
        $HazardReport = HazardReport::whereId($this->data_id);
        $files = HazardDocumentation::searchHzdID(trim($this->data_id));
        if (isset($files->first()->name_doc)) {
            unlink(storage_path('app/public/documents/hazard/' .   $files->first()->name_doc));
        }
        $HazardReport->delete();
        EventParticipants::where('reference', $this->reference)->delete();
        return redirect()->route('hazardReport');
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
        $projectExists = HazardReport::whereId($this->data_id)->exists();
        if ($projectExists) {
            $HazardReport = HazardReport::SearchId(trim($this->data_id))->first();
            $this->stepJS = $HazardReport->WorkflowDetails->name;
            $this->dispatch('berhasilUpdate', $this->stepJS);
        } else {
            return redirect()->route('hazardReport');
        }
    }
}
