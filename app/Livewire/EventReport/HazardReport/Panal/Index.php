<?php

namespace App\Livewire\EventReport\HazardReport\Panal;

use App\Models\User;
use Livewire\Component;
use App\Models\Division;
use Livewire\Attributes\On;
use App\Models\HazardReport;
use App\Models\ClassHierarchy;
use App\Models\WorkflowDetail;
use App\Models\EventUserSecurity;
use App\Models\WorkflowApplicable;
use App\Notifications\toModerator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class Index extends Component
{
    public $procced_to, $EventUserSecurity = [], $Workflows, $show = false, $workflow_detail_id, $data_id, $assign_to, $also_assign_to, $current_step, $reference,  $event_type_id, $workflow_administration_id, $status, $bg_status, $muncul = false, $responsible_role_id;
    public $wf_id, $division_id, $assign_to_old, $also_assign_to_old, $task_being_done, $workflow_template_id, $workgroup_name, $comment;
    #[On('hzrd_updated')]
    public function hzrd_updated(HazardReport $id)
    {

        $this->reference = $id->reference;
        $this->assign_to_old = $id->assign_to;
        $this->also_assign_to_old = $id->also_assign_to;
        $this->responsible_role_id = $id->WorkflowDetails->ResponsibleRole->id;
        $this->task_being_done = $id->task_being_done;
        $this->task_being_done = $id->task_being_done;
        $this->comment = $id->comment;
        $this->workflow_template_id = $id->workflow_template_id;
    }
    public function mount(HazardReport $id)
    {
        $this->data_id = $id->id;
        $this->division_id = $id->division_id;
        $this->reference = $id->reference;
        $this->assign_to = $id->assign_to;
        $this->assign_to = $id->assign_to;
        $this->also_assign_to = $id->also_assign_to;
        $this->task_being_done = $id->task_being_done;
        $this->workflow_template_id = $id->workflow_template_id;

        if ($this->division_id) {
            $divisi = Division::with(['DeptByBU.BusinesUnit.Company', 'DeptByBU.Department', 'Company', 'Section'])->whereId($this->division_id)->first();
            if (! empty($divisi->company_id) && ! empty($divisi->section_id)) {
                $this->workgroup_name = $divisi->DeptByBU->BusinesUnit->Company->name_company . '-' . $divisi->DeptByBU->Department->department_name . '-' . $divisi->Company->name_company . '-' . $divisi->Section->name;
            } elseif ($divisi->company_id) {
                $this->workgroup_name = $divisi->DeptByBU->BusinesUnit->Company->name_company . '-' . $divisi->DeptByBU->Department->department_name . '-' . $divisi->Company->name_company;
            } elseif ($divisi->section_id) {
                $this->workgroup_name = $divisi->DeptByBU->BusinesUnit->Company->name_company . '-' . $divisi->DeptByBU->Department->department_name . '-' . $divisi->Section->name;
            } else {
                $this->workgroup_name = $divisi->DeptByBU->BusinesUnit->Company->name_company . '-' . $divisi->DeptByBU->Department->department_name;
            }
        }
    }
    public function render()
    {

        $this->updatePanel();
        $this->workflow_administration_id = (!empty(WorkflowApplicable::where('type_event_report_id', $this->event_type_id)->first()->workflow_administration_id)) ? WorkflowApplicable::where('type_event_report_id', $this->event_type_id)->first()->workflow_administration_id : null;
        $this->Workflows = WorkflowDetail::where('workflow_administration_id', $this->workflow_administration_id)->where('name', $this->current_step)->get();
        $this->realtimeUpdate();
        $this->userSecurity();
        return view('livewire.event-report.hazard-report.panal.index', [
            "Workflow" => $this->Workflows
        ]);
    }
    public function userSecurity()
    {
        $userId = Auth::user()->id;
        $typeId = $this->event_type_id;
        $ClassHierarchy =  ClassHierarchy::where('division_id', [$this->division_id])->first();
        if ($ClassHierarchy) {
            $Company = $ClassHierarchy->company_category_id;
            $Department = $ClassHierarchy->dept_by_business_unit_id;
            $company = trim($Company);
            $department = trim($Department);
            // Cek apakah user adalah ERM
            $isErm = EventUserSecurity::where('user_id', $userId)
                ->where('name', $this->workgroup_name)
                ->where('responsible_role_id', 2)
                ->where('type_event_report_id', $typeId)
                ->exists();

            if ($this->current_step === 'ERM Assigned') {
                if ($isErm) {
                    $this->muncul = true; // jika role 2, maka true
                } else {
                    $this->muncul = false;
                }
            } else {
                // Cek jika dia punya role 1 dan akses ke perusahaan atau departemen
                $hasRole1Access = EventUserSecurity::where('user_id', $userId)
                    ->where('responsible_role_id', 1)
                    ->where(function ($query) use ($typeId) {
                        $query->where('type_event_report_id', $typeId)
                            ->orWhereNull('type_event_report_id');
                    })
                    ->where(function ($query) use ($company, $department) {
                        $query->searchCompany($company)->orWhere(fn($q) => $q->searchDept($department));
                    })
                    ->exists();

                $this->muncul = $hasRole1Access; // kalau punya akses, true
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
    public function updatePanel()
    {
        $HazardReport = HazardReport::whereId($this->data_id)->first();
        $this->current_step = $HazardReport->WorkflowDetails->name;
        $this->responsible_role_id = $HazardReport->WorkflowDetails->ResponsibleRole->id;
        $this->status = $HazardReport->WorkflowDetails->Status->status_name;
        $this->bg_status = $HazardReport->WorkflowDetails->Status->bg_status;
        $this->wf_id = $HazardReport->workflow_detail_id;
        $this->event_type_id = $HazardReport->event_type_id;
    }
    public function realtimeUpdate()
    {
        $ERM = ClassHierarchy::searchDivision(trim($this->division_id))->pluck('dept_by_business_unit_id');
        if ($this->procced_to === "ERM Assigned") {
            foreach ($ERM as $value) {
                if (!empty($value)) {
                    $this->EventUserSecurity = (EventUserSecurity::where('responsible_role_id', 2)->where('name', $this->workgroup_name)->where('type_event_report_id', $this->event_type_id)->exists()) ? EventUserSecurity::where('responsible_role_id', 2)->where('name', $this->workgroup_name)->where('type_event_report_id', $this->event_type_id)->get() : EventUserSecurity::where('responsible_role_id', 2)->where('name', $this->workgroup_name)->get();
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
        // Normalisasi assign input
        $this->assign_to = $this->assign_to ?: null;
        $this->also_assign_to = $this->also_assign_to ?: null;

        // Validasi
        $rules = ['procced_to' => ['required']];
        if ($this->procced_to === 'ERM Assigned') {
            $rules['assign_to'] = ['required'];
            $rules['also_assign_to'] = ['nullable'];
        }
        $this->validate($rules);

        // Ambil ID workflow detail jika ada
        if ($this->procced_to) {
            $WorkflowDetail = WorkflowDetail::where('workflow_administration_id', $this->workflow_template_id)
                ->where('name', $this->procced_to)
                ->first();

            $this->workflow_detail_id = optional($WorkflowDetail)->id;
        }

        // Siapkan field untuk update
        $closed_by = Auth::user()->lookup_name;
        $isClosed = in_array($this->procced_to, ['Closed', 'Cancelled']);

        $fields = [
            'workflow_detail_id' => $this->workflow_detail_id,
            'assign_to'          => $this->assign_to,
            'also_assign_to'     => $this->also_assign_to,
            'closed_by'          => $isClosed ? $closed_by : '',
        ];

        // Update hazard report
        HazardReport::whereId($this->data_id)->update($fields);

        // Notifikasi ke Moderator jika role 1
        if ($this->responsible_role_id == 1) {
            $moderators = User::whereIn('id', function ($query) {
                $query->select('user_id')
                    ->from('event_user_securities')
                    ->where('responsible_role_id', 1)
                    ->where('type_event_report_id', $this->event_type_id)
                    ->where('user_id', '!=', Auth::id());
            })
                ->whereNotNull('email')
                ->get();

            $url = $this->data_id;
            $subject = $this->procced_to === 'Moderator Verification'
                ? 'Hazard Report ERM Respons'
                : 'Tugas Tinjauan Laporan Bahaya - ' . $this->reference;

            foreach ($moderators as $moderator) {
                $offerData = [
                    'greeting'   => 'Kepada Yth. ' . $moderator->lookup_name,
                    'subject'    => $subject,
                    'line'       => Auth::user()->lookup_name . ' telah memperbarui status laporan hazard menjadi "' . $this->status . '". Mohon untuk ditinjau.',
                    'line2'      => 'Silakan tinjau laporan ini dengan mengklik tombol di bawah.',
                    'line3'      => 'Terima kasih atas perhatian dan kerjasamanya.',
                    'actionUrl'  => url("https://tokasafe.archimining.com/eventReport/hazardReportDetail/{$url}"),
                ];
                Notification::send($moderator, new toModerator($offerData));
            }
        }
        // Notifikasi ke assign/also_assign jika ke ERM
        if ($this->procced_to === 'ERM Assigned') {
            $url = $this->data_id;
            $komentar = strip_tags($this->comment);
            $assignedUserIds = array_filter([$this->assign_to, $this->also_assign_to]);

            $assignedUsers = User::whereIn('id', $assignedUserIds)
                ->whereNotNull('email')
                ->get();

            foreach ($assignedUsers as $user) {
                $offerData = [
                    'greeting'   => 'Kepada  ' . $user->lookup_name,
                    'subject'    => 'Hazard Report ' . $this->reference,
                    'line'       => "Moderator memberikan komentar pada laporan hazard yang dikirim kepada anda : '. $komentar  .'",
                    'line2'      => 'Silahkan periksa dengan mengklik tombol dibawah ini:',
                    'line3'      => 'Terima kasih',
                    'actionUrl'  => url("https://tokasafe.archimining.com/eventReport/hazardReportDetail/{$url}"),
                ];
                Notification::send($user, new toModerator($offerData));
            }
        }

        // Emit panel update
        $this->dispatch('alert', [
            'text' => "The Step was updated!!",
            'duration' => 3000,
            'destination' => '/contact',
            'newWindow' => true,
            'close' => true,
            'backgroundColor' => "linear-gradient(to right, #a3e635, #eab308)",
        ]);

        $this->dispatch('panel_updated', $this->data_id);
        $this->dispatch('panel_hazard');

        $this->reset('procced_to');
        $this->show = false;
    }
}
