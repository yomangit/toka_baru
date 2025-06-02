<?php

namespace App\Livewire\EventReport\HazardReport\Action;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ActionHazard;
use App\Models\HazardReport;
use Livewire\Attributes\Validate;

class Create extends Component
{
    public $search_report_by = '';
    public $modal = 'modal', $divider, $action_id, $orginal_due_date, $current_step;
    #[Validate]
    public $hazard_id, $responsibility, $responsibility_name, $followup_action, $actionee_comment, $action_condition, $due_date, $completion_date;

    #[On('modalActionHazard')]
    public function modalActionHazard(HazardReport $hazard, ActionHazard $action)
    {
        $this->modal = ' modal-open';
        $this->hazard_id = $hazard->id;
        $this->current_step = $hazard->WorkflowDetails->name;
        $this->action_id = $action->id;
        if ($this->action_id) {
            $this->responsibility = $action->responsibility;
            $this->responsibility_name = $action->users->lookup_name;
            $this->followup_action = $action->followup_action;
            $this->actionee_comment = $action->actionee_comment;
            $this->action_condition = $action->action_condition;
            $this->due_date = $action->due_date;
            $this->completion_date = $action->completion_date;
        }
    }
    public function render()
    {
        if ($this->action_id) {
            $this->divider = "Update Action";
        } else {
            $this->divider = "Add Action";
        }
        return view('livewire.event-report.hazard-report.action.create', [
            'Report_By' => User::searchNama(trim($this->responsibility_name))->limit(500)->get()
        ]);
    }

    public function rules()
    {
        return [
            'responsibility_name' => ['nullable'],
            'followup_action' => ['nullable'],
            'actionee_comment' => ['nullable'],
            'action_condition' => ['nullable'],
            'due_date' => ['nullable'],
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
        ActionHazard::updateOrCreate(
            ['id' => $this->action_id],
            [
                'hazard_id'  => $this->hazard_id,
                'followup_action'  => $this->followup_action,
                'actionee_comment'  => $this->actionee_comment,
                'action_condition'  => $this->action_condition,
                'responsibility'  => $this->responsibility,
                'due_date'  => $this->due_date,
                'completion_date'  => $this->completion_date,
            ]
        );
        if ($this->action_id) {
            $this->dispatch(
                'alert',
                [
                    'text' => "Data has been updated",
                    'duration' => 3000,
                    'destination' => '/contact',
                    'newWindow' => true,
                    'close' => true,
                    'backgroundColor' => "linear-gradient(to right, #00b09b, #96c93d)",
                ]
            );
            $this->reset('modal');
        } else {

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
            $this->reset('followup_action', 'actionee_comment', 'action_condition', 'due_date', 'completion_date', 'responsibility_name');
        }
        $this->dispatch('actionHazard_created');
    }

    public function reportedBy($id)
    {
        $this->responsibility = $id;
        $ReportBy = User::whereId($id)->first();
        $this->responsibility_name = $ReportBy->lookup_name;
    }


    public function openModal()
    {
        $this->modal = ' modal-open';
    }
    public function closeModal()
    {

        $this->reset('followup_action', 'actionee_comment', 'action_condition', 'due_date', 'completion_date', 'modal');
    }
}
