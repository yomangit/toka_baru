<?php

namespace App\Livewire\Admin\WorkflowStepDetail;

use Livewire\Component;
use App\Models\StatusEvent;
use Livewire\Attributes\On;
use App\Models\WorkflowDetail;
use App\Models\ResponsibleRole;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Index extends Component
{
    use RefreshDatabase;
    public $Workflowdetails, $workflowdetail_id, $Status, $ResponsibleRole,$template;
    public $name, $description, $status_event_id, $responsible_role_id, $destination_1, $destination_1_label, $destination_2, $destination_2_label, $is_cancel_step;
    
    protected $listeners = ['workflow_step_create' => 'render'];
    #[On('shere_templatename')]
    public function shere_templatename($template){
        $this->template = $template;
    }
    public function mount($template_id)
    {
        $this->template=$template_id;
    }
    public function render()
    {
       
            $this->Workflowdetails = WorkflowDetail::with(['Status','ResponsibleRole'])->searchTemplate(trim($this->template))->get();
       
        $this->Status = StatusEvent::get();
        $this->ResponsibleRole = ResponsibleRole::get();
        return view('livewire.admin.workflow-step-detail.index');
    }
    public function updateData($id){
        $this->dispatch('updateWorkflowdetail',$id);
    }
    public function delete($id){
        WorkflowDetail::whereId($id)->delete();
        
    }
    
}
