<?php

namespace App\Livewire\Admin\WorkflowAdministration;


use App\Models\WorkflowAdministration;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    public $modal = 'modal', $workflow_template_name, $workflow_template_id, $divider;

    public function mount (WorkflowAdministration $wk)
    {
            $this->workflow_template_id = $wk->id;
            $this->workflow_template_name = $wk->workflow_template_name;
    }
    public function render()
    {
        if ($this->workflow_template_id) {
            $this->divider="Edit WorkFlow Template";
        } else {
            $this->divider="Add WorkFlow Template";
        }
        return view('livewire.admin.workflow-administration.create-and-update');
    }
    public function rules()
    {
        return [
            'workflow_template_name' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'workflow_template_name.required' => 'Workflow Template Name is required',
        ];
    }
    public function store()
    {
        $this->validate();
        WorkflowAdministration::updateOrCreate([
            'id' => $this->workflow_template_id
        ], ['workflow_template_name' => $this->workflow_template_name]);
        if ($this->workflow_template_id) {
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
        $this->dispatch('Workflow_administration_create');
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
