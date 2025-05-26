<?php

namespace App\Livewire\Admin\WorkflowApplicable;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\TypeEventReport;
use Livewire\Attributes\Validate;
use App\Models\WorkflowApplicable;
use App\Models\WorkflowAdministration;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    #[Validate]
    public $type_event_report_id,$workflowApplicable_id,$divider='',$workflow_administration_id;

    public function mount(WorkflowAdministration $template,WorkflowApplicable $wa)
    {
        $this->workflow_administration_id = $template->id;
        $this->workflowApplicable_id=$wa->id;
        $this->type_event_report_id=$wa->type_event_report_id;
    }
    
    public function render()
    {
        if ($this->workflowApplicable_id) {
            $this->divider="Edit Workflow Applicable";
        } else {
            $this->divider="Add Workflow Applicable";
        }
        return view('livewire.admin.workflow-applicable.create-and-update',[
            'EventType'=>TypeEventReport::get()
        ]);
    }
    public function rules(){
        return [
            'type_event_report_id' =>'required',
        ];
    }
    public function messages(){
        return [
            'type_event_report_id.required' => 'Type event report is required',
        ];
    }
    public function store(){
        $this->validate();
        WorkflowApplicable::updateOrCreate([
            'id' => $this->workflowApplicable_id,
        ],[
            'type_event_report_id' => $this->type_event_report_id,
            'workflow_administration_id' => $this->workflow_administration_id,
        ]);
        if ($this->workflowApplicable_id) {
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
           
        }
        $this->dispatch('Workflow_Applicable_create');

    }
          /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public static function modalMaxWidth(): string
    {
        return 'md';
    }
    public static function closeModalOnClickAway(): bool
    {
        return false;
    }
}
