<?php

namespace App\Livewire\Admin\WorkflowStepDetail;

use Livewire\Component;
use App\Models\StatusEvent;
use App\Models\WorkflowDetail;
use App\Models\ResponsibleRole;
use App\Models\WorkflowAdministration;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    public $Workflowdetails, $Workflowdetail_id, $Status, $ResponsibleRole, $newstep = 'hidden', $modal = 'modal', $divider,$workflow_administration_id;
    public $name, $description, $status_event_id, $responsible_role_id, $destination_1, $destination_1_label, $destination_2, $destination_2_label, $is_cancel_step;
   
    public function mount(WorkflowAdministration $template, WorkflowDetail $wd)
    {
        $this->Workflowdetail_id=$wd->id;
        $this->workflow_administration_id = $template->id;
        $this->name = $wd->name;
        $this->description = $wd->description;
        $this->status_event_id = $wd->status_event_id;
        $this->responsible_role_id = $wd->responsible_role_id;
        $this->destination_1 = $wd->destination_1;
        $this->destination_1_label = $wd->destination_1_label;
        $this->destination_2 = $wd->destination_2;
        $this->destination_2_label = $wd->destination_2_label;
        $this->is_cancel_step = $wd->is_cancel_step;
    }
    public function rules()
    {
        return [
            'name' => ['required'],
            'description' => ['required'],
            'status_event_id' => ['required', 'integer'],
            'responsible_role_id' => ['required', 'integer'],
            'destination_1' => ['nullable'],
            'destination_1_label' => ['nullable', 'string'],
            'destination_2' => ['nullable'],
            'destination_2_label' => ['nullable', 'string'],
            'is_cancel_step' => ['required'],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'description.required' => 'Description is required',
            'status_event_id.required' => 'Status Event is required',
            'responsible_role_id.required' => 'Responsible Role is required',
            'destination_1.integer' => 'Destination 1 must required',
            'destination_2.integer' => 'Destination 2 must required',
            'is_cancel_step.required' => 'Is Cancel Step is required',
        ];
    }
    public function render()
    {
        if ($this->Workflowdetail_id) {
            $this->divider="Edit Workflow Detail";
        } else {
            $this->divider="Add Workflow Detail";
        }
        
        $this->Status = StatusEvent::get();
        $this->ResponsibleRole = ResponsibleRole::get();
        $this->Workflowdetails = WorkflowDetail::where('workflow_administration_id',$this->workflow_administration_id)->get();
        return view('livewire.admin.workflow-step-detail.create-and-update',);
    }
    public function store()
    {
        $this->validate();
        WorkflowDetail::updateOrCreate(
            ['id' => $this->Workflowdetail_id],
            [
                'name' => $this->name,
                'description' => $this->description,
                'status_event_id' => $this->status_event_id,
                'responsible_role_id' => $this->responsible_role_id,
                'destination_1' => $this->destination_1,
                'destination_1_label' => $this->destination_1_label,
                'destination_2' => $this->destination_2,
                'destination_2_label' => $this->destination_2_label,
                'is_cancel_step' => $this->is_cancel_step,
                'workflow_administration_id' => $this->workflow_administration_id,
            ]
        );

        if ($this->responsible_role_id) {
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
            $this->forceClose()->closeModal();
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
            $this->reset(['name','description','status_event_id','responsible_role_id','destination_1','destination_1_label','destination_2','destination_2_label','is_cancel_step']);
        }
        $this->dispatch('workflow_step_create');
    }
           /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public static function modalMaxWidth(): string
    {
        return '3xl';
    }
    public static function closeModalOnClickAway(): bool
    {
        return false;
    }
}
