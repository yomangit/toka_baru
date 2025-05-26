<?php

namespace App\Livewire\EventReport\IncidentReport\Panel;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ClassHierarchy;
use App\Models\IncidentReport;
use App\Models\WorkflowDetail;
use App\Models\EventUserSecurity;
use App\Models\WorkflowApplicable;
use App\Notifications\toModerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class Index extends Component
{
    public $assign_to, $also_assign_to, $responsible_role_id, $tampilkan = false, $data_id, $workgroup_id, $event_type_id, $current_step, $status, $bg_status, $wf_id, $procced_to, $show = false, $EventUserSecurity = [], $Workflows, $workflow_administration_id, $workflow_detail_id;
    public  $division_id, $assign_to_old, $also_assign_to_old, $reference;
    public function mount(IncidentReport $id)
    {
        $this->data_id = $id->id;
        $this->assign_to = $id->assign_to;
        $this->also_assign_to = $id->also_assign_to;
    }
    public function incident_updated()
    {
        $incidentReport = IncidentReport::whereId($this->data_id)->first();
        $this->reference = $incidentReport->reference;
        $this->responsible_role_id = $incidentReport->WorkflowDetails->ResponsibleRole->id;
        $this->current_step = $incidentReport->WorkflowDetails->name;
        $this->status = $incidentReport->WorkflowDetails->Status->status_name;
        $this->bg_status = $incidentReport->WorkflowDetails->Status->bg_status;
        $this->wf_id = $incidentReport->workflow_detail_id;
        $this->division_id = $incidentReport->division_id;
        $this->event_type_id = $incidentReport->event_type_id;
    }

    public function render()
    {
        $this->incident_updated();
        $this->workflow_administration_id = (!empty(WorkflowApplicable::where('type_event_report_id', $this->event_type_id)->first()->workflow_administration_id)) ? WorkflowApplicable::where('type_event_report_id', $this->event_type_id)->first()->workflow_administration_id : null;
        $this->Workflows = WorkflowDetail::where('workflow_administration_id', $this->workflow_administration_id)->where('name', $this->current_step)->get();
        $this->realtimeUpdate();
        $this->userSecurity();
        return view('livewire.event-report.incident-report.panel.index', [
            "Workflow" => $this->Workflows,
        ]);
    }
    public function userSecurity()
    {
        $ClassHierarchy =  ClassHierarchy::where('division_id', [$this->division_id])->first();
        if ($ClassHierarchy) {
            $Company = $ClassHierarchy->company_category_id;
            $Department = $ClassHierarchy->dept_by_business_unit_id;
            $User = (EventUserSecurity::where('user_id', Auth::user()->id)->where('responsible_role_id',  2)->where('type_event_report_id', $this->event_type_id)->exists()) ? EventUserSecurity::where('user_id', Auth::user()->id)->where('responsible_role_id',  2)->where('type_event_report_id', $this->event_type_id)->pluck('user_id') : EventUserSecurity::where('user_id', Auth::user()->id)->where('responsible_role_id',  2)->pluck('user_id');
            foreach ($User as $value) {
                if (EventUserSecurity::where('user_id', $value)->searchCompany(trim($Company))->exists()) {
                    $this->tampilkan = true;
                } elseif (EventUserSecurity::where('user_id', $value)->searchDept(trim($Department))->exists()) {
                    $this->tampilkan = true;
                } else {
                    $this->tampilkan = false;
                }
            }
        } else {
            $this->dispatch(
                'alert',
                [
                    'text' => "the Responsibility Workgroup not have class Hierarchy!!",
                    'duration' => 5000,
                    'destination' => '/contact',
                    'newWindow' => true,
                    'close' => true,
                    'backgroundColor' => "linear-gradient(to right, #9a3412, #fbbf24)",
                ]
            );
        }
    }
    public function realtimeUpdate()
    {
        if ($this->procced_to === "Assign & Investigation") {
            $ERM = ClassHierarchy::searchDivision(trim($this->division_id))->pluck('dept_by_business_unit_id');
            foreach ($ERM as $value) {
                if (!empty($value)) {
                    $this->EventUserSecurity = (EventUserSecurity::where('responsible_role_id', 2)->where('dept_by_business_unit_id', $value)->where('type_event_report_id', $this->event_type_id)->exists()) ? EventUserSecurity::where('responsible_role_id', 2)->where('dept_by_business_unit_id', $value)->where('type_event_report_id', $this->event_type_id)->get() : EventUserSecurity::where('responsible_role_id', 2)->where('dept_by_business_unit_id', $value)->get();

                    $this->show = true;
                } else {
                    $this->show = false;
                }
            }
        } else {
            $this->show = false;
        }
    }
    public function store()
    {
        if (empty($this->assign_to)) {
            $this->assign_to = null;
        }
        if (empty($this->also_assign_to)) {
            $this->also_assign_to = null;
        }
        if ($this->procced_to === "Assign & Investigation") {
            $this->validate([
                'procced_to' => ['required'],
                'assign_to' => ['required'],
                'also_assign_to' => ['nullable'],
            ]);
        } else {
            $this->validate([
                'procced_to' => ['required'],
            ]);
        }
        if ($this->procced_to) {
            $WorkflowDetail = WorkflowDetail::where('name', $this->procced_to)->first();
            $this->workflow_detail_id = $WorkflowDetail->id;
            $ResponsibleRole = $WorkflowDetail->responsible_role_id;
        }
        IncidentReport::whereId($this->data_id)->update([
            'workflow_detail_id' => $this->workflow_detail_id,
            'assign_to' => $this->assign_to,
            'also_assign_to' => $this->also_assign_to,
        ]);
        $this->dispatch(
            'alert',
            [
                'text' => "The Step was updated!!",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #a3e635, #eab308)",
            ]
        );
        if ($this->responsible_role_id == 1) {
            $getModerator = EventUserSecurity::where('responsible_role_id', $this->responsible_role_id)->where('user_id', 'NOT LIKE', Auth::user()->id)->pluck('user_id')->toArray();
            $User = User::whereIn('id', $getModerator)->get();
            $url = $this->data_id;
            foreach ($User as $key => $value) {
                $users = User::whereId($value->id)->get();
                $offerData = [
                    'greeting' => $value->lookup_name,
                    'subject' => '',
                    'line' =>  $value->lookup_name . ' ' . 'has updated the hazard report status to ' . $this->status . ', please review',
                    'line2' => 'Please review this report',
                    'line3' => 'Thank you',
                    'actionUrl' => url("/eventReport/incidentReportDetail/$url"),
                ];
                Notification::send($users, new toModerator($offerData));
            }
        }
        if ($this->procced_to === "Assign & Investigation") {
            if ($this->assign_to) {
                $Users = User::where('id', $this->assign_to)->whereNotNull('email')->get();
                foreach ($Users as $key => $value) {
                    $report_to = User::whereId($value->id)->get();
                    $offerData = [
                        'greeting' =>  '',
                        'subject' => '',
                        'line' =>  'You have been assigned to a hazard report with reference ' . $this->reference . ', please review',
                        'line2' => 'Please check by click the button below',
                        'line3' => 'Thank you',
                        'actionUrl' => url("/eventReport/incidentReportDetail/$url"),
                    ];
                    Notification::send($report_to, new toModerator($offerData));
                }
            }
            if ($this->also_assign_to) {
                $Users = User::where('id', $this->also_assign_to)->whereNotNull('email')->get();
                foreach ($Users as $key => $value) {
                    $report_to = User::whereId($value->id)->get();
                    $offerData = [
                        'greeting' =>  '',
                        'subject' => '',
                        'line' =>  'You have been assigned to a hazard report with reference ' . $this->reference . ', please review',
                        'line2' => 'Please check by click the button below',
                        'line3' => 'Thank you',
                        'actionUrl' => url("/eventReport/incidentReportDetail/$url"),
                    ];
                    Notification::send($report_to, new toModerator($offerData));
                }
            }
        }
        if ($this->procced_to === "Closed") {
            if ($this->assign_to) {
                $Users = User::where('id', $this->assign_to)->whereNotNull('email')->get();
                foreach ($Users as $key => $value) {
                    $report_to = User::whereId($value->id)->get();
                    $offerData = [
                        'greeting' =>  '',
                        'subject' => '',
                        'line' =>   Auth::user()->lookup_name . ' Closed this Hazard Report',
                        'line2' => 'Please check by click the button below',
                        'line3' => 'Thank you',
                        'actionUrl' => url("/eventReport/incidentReportDetail/$url"),
                    ];
                    Notification::send($report_to, new toModerator($offerData));
                }
            }
            if ($this->also_assign_to) {
                $Users = User::where('id', $this->also_assign_to)->whereNotNull('email')->get();
                foreach ($Users as $key => $value) {
                    $report_to = User::whereId($value->id)->get();
                    $offerData = [
                        'greeting' =>  '',
                        'subject' => '',
                        'line' =>   Auth::user()->lookup_name . ' Closed this Hazard Report',
                        'line2' => 'Please check by click the button below',
                        'line3' => 'Thank you',
                        'actionUrl' => url("/eventReport/incidentReportDetail/$url"),
                    ];
                    Notification::send($report_to, new toModerator($offerData));
                }
            }
        }
        $this->dispatch('panel_incident', $this->data_id);
        $this->dispatch('panel_incident_realtime');
        $this->reset('procced_to');
    }
}
