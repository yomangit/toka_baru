<?php

namespace App\Livewire\EventReport\HazardReport;

use App\Models\BusinesUnit;
use App\Models\choseEventType;
use App\Models\Company;
use App\Models\DeptByBU;
use App\Models\Division;
use App\Models\Eventsubtype;
use App\Models\EventUserSecurity;
use App\Models\HazardReport;
use App\Models\LocationEvent;
use App\Models\TypeEventReport;
use App\Models\User;
use App\Models\WorkflowDetail;
use App\Notifications\toModerator;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Request;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CreateAndUpdate extends Component
{
    use WithFileUploads, WithPagination;

    // Properti utama
    public $location_name, $location_id, $date, $site_id;
    public $event_type_id, $sub_event_type_id;
    public $report_by, $report_byName, $report_by_nolist;
    public $report_to, $report_toName, $report_to_nolist;
    public $division_id, $workgroup_name, $workflow_template_id, $workflow_detail_id;
    public $documentation, $description, $task_being_done;
    public $immediate_corrective_action, $suggested_corrective_action, $corrective_action_suggested;
    public $kondisi_tidak_aman, $tindakan_tidak_aman, $tindakkan_selanjutnya;
    public $company_involved, $risk_consequence_id, $risk_likelihood_id;
    public $reference, $fileUpload;
    public $searchLikelihood = '', $searchConsequence = '', $tablerisk_id, $risk_assessment_id;
    public $search_workgroup = '', $divisi_search = '', $search_report_by = '', $search_report_to = '', $location_search = '';
    public $parent_Company, $business_unit, $dept, $select_divisi;
    public $dropdownLocation = 'dropdown', $hidden = 'block';
    public $dropdownWorkgroup = 'dropdown', $hiddenWorkgroup = 'block';
    public $dropdownReportBy = 'dropdown', $hiddenReportBy = 'block';
    public $dropdownReportTo = 'dropdown', $hiddenReportTo = 'block';
    public $showLocation = false, $show = false;
    public $show_immidiate = 'yes';
    public $divider = 'Input Hazard Report', $TableRisk = [], $Event_type = [], $RiskAssessment = [], $EventSubType = [], $ResponsibleRole;
    public $data = [];

    public function mount()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->report_byName = $user->lookup_name ?? $user->name;
            $this->report_by     = $user->id;
        }
    }

    public function rules()
    {
        $baseRules = [
            'workgroup_name'        => ['required'],
            'event_type_id'         => ['required'],
            'sub_event_type_id'     => ['required'],
            'report_byName'         => ['required'],
            'date'                  => ['required'],
            'documentation'         => 'nullable|mimes:jpg,jpeg,png,svg,gif,xlsx,pdf,docx',
            'description'           => ['required'],
            'location_id'           => ['required'],
            'location_name'         => ['required'],
            'tindakkan_selanjutnya' => ['required'],
        ];

        if ($this->show_immidiate === 'yes') {
            $baseRules['immediate_corrective_action'] = ['required'];
        }

        return $baseRules;
    }

    public function messages()
    {
        return [
            '*.required'            => 'kolom wajib di isi',
            'documentation.mimes'  => 'hanya format jpg,jpeg,png,svg,gif,xlsx,pdf,docx file types are allowed',
        ];
    }

    public function reportedBy($id)
    {
        $user = User::find($id);
        $this->report_by        = $id;
        $this->report_byName    = $user->lookup_name;
        $this->report_by_nolist = null;
        $this->hiddenReportBy   = 'hidden';
    }

    public function reportedTo($id)
    {
        $user = User::find($id);
        $this->report_to        = $id;
        $this->report_toName    = $user->lookup_name;
        $this->report_to_nolist = null;
        $this->hiddenReportTo   = 'hidden';
    }

    public function ReportByAndReportTo()
    {
        if (!empty($this->report_by_nolist)) {
            $this->report_by     = null;
            $this->report_byName = $this->report_by_nolist;
        }
    }

    public function select_division($id)
    {
        $this->division_id     = $id;
        $this->hiddenWorkgroup = 'hidden';
        $this->hiddenReportBy  = 'hidden';
    }

    public function clickReportBy()
    {
        $this->dropdownReportBy = 'dropdown dropdown-open dropdown-end';
        $this->hiddenReportBy = 'block';
    }
    public function clickReportTo()
    {
        $this->hiddenReportTo = 'block';
    }
    public function clickWorkgroup()
    {
        $this->dropdownWorkgroup = 'dropdown dropdown-open dropdown-end';
        $this->hiddenWorkgroup = 'block';
    }

    public function changeConditionDivision()
    {
        $this->business_unit = $this->dept = $this->select_divisi = $this->division_id = null;
    }

    public function realTimeFunc()
    {
        $this->showLocation = !empty($this->location_id);

        if (choseEventType::where('route_name', 'LIKE', Request::getPathInfo())->exists()) {
            $eventType        = choseEventType::where('route_name', 'LIKE', Request::getPathInfo())->pluck('event_type_id');
            $this->Event_type = TypeEventReport::whereIn('id', $eventType)->get();
        }

        $this->EventSubType = $this->event_type_id ? Eventsubtype::where('event_type_id', $this->event_type_id)->get() : [];

        if ($this->documentation) {
            $this->fileUpload = pathinfo($this->documentation->getClientOriginalName(), PATHINFO_EXTENSION);
        }

        $this->show = Auth::check() && Auth::user()->role_user_permit_id == 1;

        $query = Division::with(['DeptByBU.BusinesUnit.Company', 'DeptByBU.Department', 'Company', 'Section']);

        $this->divisi_search = $this->division_id
            ? $query->whereId($this->division_id)->searchParent(trim($this->parent_Company))->searchBU(trim($this->business_unit))->searchDept(trim($this->dept))->searchComp(trim($this->select_divisi))->orderBy('dept_by_business_unit_id', 'asc')->get()
            : $query->searchDeptCom(trim($this->workgroup_name))->searchParent(trim($this->parent_Company))->searchBU(trim($this->business_unit))->searchDept(trim($this->dept))->searchComp(trim($this->select_divisi))->orderBy('dept_by_business_unit_id', 'asc')->get();

        if ($this->division_id) {
            $divisi = Division::with(['DeptByBU.BusinesUnit.Company', 'DeptByBU.Department', 'Company', 'Section'])->find($this->division_id);
            if ($divisi) {
                $parts = [
                    optional($divisi->DeptByBU->BusinesUnit->Company)->name_company,
                    optional($divisi->DeptByBU->Department)->department_name,
                    optional($divisi->Company)->name_company,
                    optional($divisi->Section)->name,
                ];
                $this->workgroup_name = implode('-', array_filter($parts));
            }
        }

        if (WorkflowDetail::where('workflow_administration_id', $this->workflow_template_id)->exists()) {
            $workflow = WorkflowDetail::where('workflow_administration_id', $this->workflow_template_id)->first();
            $this->workflow_detail_id = $workflow->id;
            $this->ResponsibleRole    = $workflow->responsible_role_id;
        }
    }

    public function render()
    {
        $this->realTimeFunc();
        $this->ReportByAndReportTo();

        return view('livewire.event-report.hazard-report.create-and-update', [
            'Report_By' => User::searchNama(trim($this->report_byName))->paginate(100, ['*'], 'Report_By'),
            'Report_To' => User::searchNama(trim($this->report_toName))->paginate(100, ['*'], 'Report_To'),
            'Division'  => $this->divisi_search,
            'EventType' => $this->Event_type,
            'Location'  => LocationEvent::get(),
        ])->extends('base.index', ['header' => 'Hazard Report', 'title' => 'Hazard Report'])->section('content');
    }

    public function store()
    {
        $this->reference = $this->generateReference();
        $this->validate();

        $file_name = '';
        if (!empty($this->documentation)) {
            $file_name        = $this->documentation->getClientOriginalName();
            $this->fileUpload = pathinfo($file_name, PATHINFO_EXTENSION);
            $this->documentation->storeAs('public/documents/hzd', $file_name);
        }

        if ($this->show_immidiate === 'no') {
            $this->immediate_corrective_action = null;
        }

        $closed_by = $this->tindakkan_selanjutnya == 0
            ? optional(WorkflowDetail::where('workflow_administration_id', $this->workflow_template_id)->where('name', 'like', '%closed%')->first())->id
            : '';

        $fields = [
            'event_type_id'               => $this->event_type_id,
            'sub_event_type_id'           => $this->sub_event_type_id,
            'reference'                   => $this->reference,
            'report_by'                   => $this->report_by,
            'report_to'                   => $this->report_to,
            'division_id'                 => $this->division_id,
            'date'                        => DateTime::createFromFormat('d-m-Y : H:i', $this->date)->format('Y-m-d : H:i'),
            'location_name'               => $this->location_name,
            'event_location_id'           => $this->location_id,
            'site_id'                     => $this->site_id,
            'show_immidiate'              => $this->show_immidiate,
            'kondisi_tidak_aman'          => $this->kondisi_tidak_aman,
            'tindakan_tidak_aman'         => $this->tindakan_tidak_aman,
            'tindakkan_selanjutnya'       => $this->tindakkan_selanjutnya,
            'company_involved'            => $this->company_involved,
            'risk_consequence_id'         => $this->risk_consequence_id,
            'risk_likelihood_id'          => $this->risk_likelihood_id,
            'workgroup_name'              => $this->workgroup_name,
            'report_byName'               => $this->report_byName,
            'report_toName'               => $this->report_toName,
            'task_being_done'             => $this->task_being_done,
            'documentation'               => $file_name,
            'description'                 => $this->description,
            'immediate_corrective_action' => $this->immediate_corrective_action,
            'suggested_corrective_action' => $this->suggested_corrective_action,
            'corrective_action_suggested' => $this->corrective_action_suggested,
            'report_by_nolist'            => $this->report_by_nolist,
            'report_to_nolist'            => $this->report_to_nolist,
            'workflow_detail_id'          => $this->workflow_detail_id,
            'workflow_template_id'        => $this->workflow_template_id,
            'closed_by'                   => $closed_by,
        ];

        $hazard = HazardReport::create($fields);
        $url    = $hazard->id;

        // Notification to moderator
        $moderatorIds = EventUserSecurity::where('responsible_role_id', $this->ResponsibleRole)
            ->when(Auth::check(), fn($q) => $q->where('user_id', '!=', Auth::id()))
            ->pluck('user_id')
            ->toArray();

        $users = User::whereIn('id', $moderatorIds)->get();
        $data  = [
            'greeting'  => 'Hi',
            'subject'   => "Hazard Report: {$this->task_being_done}",
            'line'      => "{$this->report_byName} has submitted a hazard report, please review",
            'line2'     => 'Click the button below',
            'line3'     => 'Thank you',
            'actionUrl' => url("/eventReport/hazardReportDetail/{$url}"),
        ];
        Notification::send($users, new toModerator($data));

        // Notification to report_to
        if ($this->report_to) {
            $report_to = User::where('id', $this->report_to)->whereNotNull('email')->get();
            $data['greeting'] = "Hi {$this->report_toName}";
            $data['subject']  = "Hazard Report Reference {$this->reference}";
            $data['line']     = "{$this->report_byName} has sent a hazard report to you";
            Notification::send($report_to, new toModerator($data));
        }

        $this->dispatch('alert', [
            'text'            => "Laporan Hazard Anda Sudah Terkirim, Terima kasih sudah melapor!!!",
            'duration'        => 5000,
            'destination'     => '/contact',
            'newWindow'       => true,
            'close'           => true,
            'backgroundColor' => "linear-gradient(to right, #06b6d4, #22c55e)",
        ]);

        $this->dispatch('buttonClicked', ['duration' => 4000]);
        $this->clearFields();
    }

    public function generateReference()
    {
        $prefix  = "TT–OHS–HZD-";
        $latest  = HazardReport::latest()->first();
        $number  = $latest ? $latest->id + 1 : 1;
        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function clearFields()
    {
        $fields = [
            'report_byName',
            'report_toName',
            'workgroup_name',
            'division_id',
            'date',
            'documentation',
            'description',
            'immediate_corrective_action',
            'location_name',
            'location_id',
            'kondisi_tidak_aman',
            'tindakan_tidak_aman',
            'tindakkan_selanjutnya',
            'company_involved',
            'task_being_done',
            'suggested_corrective_action',
            'corrective_action_suggested',
            'risk_consequence_id',
            'risk_likelihood_id',
            'report_by_nolist',
            'report_to_nolist',
            'workflow_detail_id',
            'reference',
            'fileUpload',
            'event_type_id',
            'sub_event_type_id',
            'site_id',
        ];

        foreach ($fields as $field) {
            $this->$field = '';
        }

        $this->showLocation = false;
    }
}
