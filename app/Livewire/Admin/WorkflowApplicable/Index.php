<?php

namespace App\Livewire\Admin\WorkflowApplicable;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\WorkflowApplicable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Index extends Component
{

    public $WorkflowApplicable, $template,$template_id;
    protected $listeners = [
        'Workflow_Applicable_create' => 'render',
    ];
    #[On('shere_templatename')]
    public function shere_templatename($template)
    {

        $this->template = $template;
    }
    public function mount($template_id)
    {
       
        $this->template=$template_id;
      
    }
    public function render()
    {
        $this->WorkflowApplicable =WorkflowApplicable::where('workflow_administration_id',$this->template)->get();
        return view('livewire.admin.workflow-applicable.index');
    }

    public function delete($id)
    {
        $deleteFile = WorkflowApplicable::whereId($id);
        $this->dispatch(
            'alert',
            [
                'text' => "Deleted Data Successfully!!",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #f97316, #ef4444)",
            ]
        );
        $deleteFile->delete();
    }
}
