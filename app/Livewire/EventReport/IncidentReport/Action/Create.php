<?php

namespace App\Livewire\EventReport\IncidentReport\Action;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ActionIncident;
use App\Models\IncidentReport;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;
class Create extends Component
{
    use WithPagination;
    public $search_report_by = '';
    public $modal,$divider,$action_id,$orginal_due_date,$current_step;
    #[Validate]
    public $incident_id,$responsibility,$responsibility_name,$followup_action,$actionee_comment,$action_condition,$due_date,$completion_date;

    #[On('modalActionIncident')]
    public function modalActionIncident(IncidentReport $dataIncident, ActionIncident $action)
    {
       
        $this->modal = "modal-open";
        $this->incident_id = $dataIncident->id ;
        
        $this->action_id = $action->id;
        if ( $this->action_id ) {
            $this->followup_action =$action->followup_action;
            $this->responsibility = $action->responsibility;
            $this->responsibility_name = $action->users->lookup_name;
            $this->actionee_comment = $action->actionee_comment;
            $this->action_condition = $action->action_condition;
            $this->due_date = $action->due_date;
            $this->completion_date = $action->completion_date;
        }
        
    }
    public function render()
    {
        if ($this->action_id) {
            $this->divider="Update Action";
        } else {
            $this->divider="Add Action";
        }
        
        return view('livewire.event-report.incident-report.action.create',[
             'User' =>User::searchNama(trim($this->responsibility_name))->limit(500)->get()
        ]);
    }
  
    public function rules(){
        return [
           'responsibility_name' => ['required'],
           'followup_action' => ['required'],
           'actionee_comment' => ['nullable'],
           'action_condition' => ['nullable'],
           'due_date' => ['nullable'],
           'completion_date' => ['nullable'],
        ];
    }
    public function message(){
        return [
           'followup_action.required' => 'Follow Up Action is required',
        ];
    }
    public function store(){
        $this->validate();
        ActionIncident::updateOrCreate(
            ['id' => $this->action_id],
            [
                'incident_id'  =>$this->incident_id ,
                'followup_action'  =>$this->followup_action ,
                'actionee_comment'  =>$this->actionee_comment ,
                'action_condition'  =>$this->action_condition ,
                'responsibility'  =>$this->responsibility ,
                'due_date'  =>$this->due_date ,
                'completion_date'  =>$this->completion_date ,
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
         $this->closeModal();
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
            $this->reset('followup_action','actionee_comment','action_condition','due_date','completion_date','modal','responsibility');
            
        }
        $this->dispatch('actionIncident_created');
    }

    public function reportedBy(User $id)
    {
        $this->responsibility = $id->id;
        $this->responsibility_name = $id->lookup_name;
    }

    public function closeModal()
    {
        
        $this->reset('followup_action','actionee_comment','action_condition','due_date','completion_date','modal','responsibility');
    }
}
