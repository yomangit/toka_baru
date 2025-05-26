<?php

namespace App\Livewire\EventReport\EventPartisipan;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\HazardReport;
use App\Models\EventParticipants;

class Index extends Component
{
    protected $listeners = ['eventParticipan_created' => 'render'];
    public $data_id,$reference='',$current_step;
    public function mount($id)
    {
        $this->data_id = $id;
        $HazardReport = HazardReport::whereId($id)->first();
        $this->reference = $HazardReport->reference;
    }
    public function render()
    {
        $this->updatePanel();
        return view('livewire.event-report.event-partisipan.index', [
            'EventParticipants' => EventParticipants::where('reference', 'LIKE', '%' . $this->reference. '%')->get(),
        ]);
    }
    #[On('panel_hazard')]
    public function updatePanel()
    {
        $HazardReport = HazardReport::whereId($this->data_id)->first();
        $this->current_step = $HazardReport->WorkflowDetails->name;
    }
    public function updateData($id)
    {
        $this->dispatch('eventParticipan_updated', $id);
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
