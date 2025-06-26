<?php

namespace App\Livewire\EventReport\HazardReport\Action;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ActionHazard;
use App\Models\HazardReport;
use App\Models\EventUserSecurity;
use Livewire\Attributes\Validate;
use App\Notifications\toModerator;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    public $search_report_by = '', $hiddenResponsibility = 'block';
    public $modal = 'modal', $divider, $action_id, $orginal_due_date, $current_step;
    #[Validate]
    public $hazard_id,$responsible_role_id,$reference, $responsibility, $responsibility_name, $followup_action, $actionee_comment, $action_condition, $due_date, $completion_date;

    #[On('modalActionHazard')]
    public function modalActionHazard(HazardReport $hazard, ActionHazard $action)
    {
        $this->modal = ' modal-open';
        $this->hazard_id = $hazard->id;
        $this->current_step = $hazard->WorkflowDetails->name;
         $this->responsible_role_id = $hazard->WorkflowDetails->responsible_role_id;
         $this->reference = $hazard->reference;
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
    public function clickResponsibility()
    {
        $this->hiddenResponsibility = 'block';
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
            'followup_action' => ['required'],
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

         $url = $this->hazard_id;
         if ($this->responsible_role_id = 1) {
            $getModerator = EventUserSecurity::where('responsible_role_id', $this->responsible_role_id)->where('user_id', 'NOT LIKE', Auth::user()->id)->pluck('user_id')->toArray();
            $User = User::whereIn('id', $getModerator)->get();

            foreach ($User as $key => $value) {
                $users = User::whereId($value->id)->get();
                $offerData = [
                    'greeting' => 'Hi' . '' .   $value->lookup_name,
                    'subject' => 'Hazard Report' . ' ' . $this->reference,
                    'line' => $this->responsibility_name . ' ' . 'has update a hazard report Action, please review',
                    'line2' => 'Please review this report',
                    'line3' => 'Thank you',
                    'actionUrl' => url("/eventReport/hazardReportDetail/$url"),
                ];
                Notification::send($users, new toModerator($offerData));
            }
        }
        $this->dispatch('actionHazard_created');
    }

    public function reportedBy($id)
    {
        $this->responsibility = $id;
        $ReportBy = User::whereId($id)->first();
        $this->responsibility_name = $ReportBy->lookup_name;
        $this->hiddenResponsibility = 'hidden';
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
