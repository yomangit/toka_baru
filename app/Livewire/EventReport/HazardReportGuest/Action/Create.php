<?php

namespace App\Livewire\EventReport\HazardReportGuest\Action;

use App\Models\User;
use Livewire\Component;
use App\Models\ActionModalHzdGuest;

class Create extends Component
{
    public $modal, $observer_id, $divider;
    public $report_by, $report_id;
    public $action, $due_date, $completion_date, $reference, $pto_id;
    public function mount($reference)
    {
        $this->reference = $reference;
    }
    public function reportByClick(User $user)
    {
        $this->report_by = $user->lookup_name;
        $this->report_id = $user->id;
    }
    public function rules()
    {
        return [
            'responsibility_name' => ['nullable'],
            'followup_action' => ['required'],
            'actionee_comment' => ['nullable'],
            'action_condition' => ['nullable'],
            'due_date' => ['nullable'],
            'reference' => ['required'],
            'completion_date' => ['nullable'],
        ];
    }
    public function message()
    {
        return [
            'followup_action.required' => 'Follow Up Action is required',
        ];
    }
    public function store()
    {
        $this->validate();
        ActionModalHzdGuest::create(
            [
                'hazard_id'  => $this->hazard_id,
                'reference'  => $this->reference,
                'followup_action'  => $this->followup_action,
                'actionee_comment'  => $this->actionee_comment,
                'action_condition'  => $this->action_condition,
                'responsibility'  => $this->responsibility,
                'due_date'  => $this->due_date,
                'completion_date'  => $this->completion_date,
            ]
        );
        $this->dispatch(
            'alert',
            [
                'text' => "action sudah di tambahkan!!",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #00b09b, #96c93d)",
            ]
        );
        $this->dispatch('action_hzd');
    }
    public function render()
    {
        $this->divider = "Add Action";
        return view('livewire.event-report.hazard-report-guest.action.create', [
            'Report_by' => User::searchFor(trim($this->report_by))->limit(1000)->get(),
        ]);
    }
}
