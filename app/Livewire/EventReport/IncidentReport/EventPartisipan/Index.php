<?php

namespace App\Livewire\EventReport\IncidentReport\EventPartisipan;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\IncidentReport;
use App\Models\EventParticipants;

class Index extends Component
{
    protected $listeners = ['eventParticipanIncident_created' => 'render'];
    public $data_id,$reference='',$current_step;
    public function mount($id)
    {
        $this->data_id = $id;
        $IncidentReport = IncidentReport::whereId($id)->first();
        $this->reference = $IncidentReport->reference;
    }
    public function render()
    {
        $this->updatePanel();
        return view('livewire.event-report.incident-report.event-partisipan.index',[
            'EventParticipants' => EventParticipants::where('reference', 'LIKE', '%' . $this->reference. '%')->get(),
        ]);
    }
     #[On('panel_incident_realtime')]
    public function updatePanel()
    {
        $IncidentReport = IncidentReport::whereId($this->data_id)->first();
        $this->current_step = $IncidentReport->WorkflowDetails->name;
    }
    public function updateData($id)
    {
        $this->dispatch('eventParticipanIncident_updated', $id);
    }
    public function delete($id)
    {
        $deleteFile = EventParticipants::whereId($id);
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
