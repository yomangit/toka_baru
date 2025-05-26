<?php

namespace App\Livewire\Admin\WorkflowAdministration;

use App\Models\WorkflowAdministration;
use Livewire\Component;

class Index extends Component
{
    public $template_name,$template_id,$hidden=false;
    protected $listeners = ['Workflow_administration_create' => 'render'];
    public function render()
    {
        // if($this->template_name){
        //     $this->dispatch('shere_templatename',$this->template_name);
        //     $this->hidden = true;
        // }
        // else{
        //     $this->hidden = false;
        // }
        return view('livewire.admin.workflow-administration.index',[
            "WorkflowAdministration" => WorkflowAdministration::get()
        ])->extends('base.index', ['header' => 'Workflow Administration', 'title' => 'Workflow Administration'])->section('content');
    }
    
    public function send_templates($id,$name){
        $this->template_name = $name;
        $this->template_id = $id;
        $this->dispatch('shere_templatename',$id);
        $this->hidden = true;
    }

    public function updateData($id)
    {
        $this->dispatch('updateWorkflowAdministration', $id);
    }
    public function delete($id){
        $deleteFile = WorkflowAdministration::whereId($id);
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
