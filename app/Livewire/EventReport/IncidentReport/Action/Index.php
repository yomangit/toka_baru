<?php

namespace App\Livewire\EventReport\IncidentReport\Action;

use DateTime;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\ActionIncident;
use App\Models\IncidentReport;

class Index extends Component
{
    use WithPagination;
    public $search='';
    public $incident_id,$task_being_done,$orginal_due_date,$current_step;
    protected $listeners = [
        'actionIncident_created' => 'render',
    ];
    public function mount($id)
    {
        $this->incident_id = $id;
        $Incident = IncidentReport::where('id', $this->incident_id)->first();
        $this->task_being_done = $Incident->task_being_done; 
        $this->orginal_due_date =DateTime::createFromFormat('Y-m-d : H:i', $Incident->date)->format('d-m-Y');
    }
    public function render()
    {
        $this->updatePanel();
        return view('livewire.event-report.incident-report.action.index',[
            'ActionIncident' => ActionIncident::searchIncident(trim($this->search))->where('incident_id',$this->incident_id)->with('users')->paginate(20)
        ]);
    }
    #[On('panel_incident_realtime')]
    public function updatePanel()
    {
        $IncidentReport = IncidentReport::whereId($this->incident_id)->first();
        $this->current_step = $IncidentReport->WorkflowDetails->name;
    }
    public function updateData($id)
    {
        $this->dispatch('action_incident_update', $id);
    }
    public function delete($id)
    {
        $deleteFile = ActionIncident::whereId($id);
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
