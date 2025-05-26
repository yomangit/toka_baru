<?php

namespace App\Livewire\EventReport\IncidentReport\Documentation;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\IncidentReport;
use App\Models\IncidentDocumentation;

class Index extends Component
{
    public $incident_id, $current_step;
    use WithPagination;
    protected $listeners = [
        'documents_created' => 'render',
    ];
    public function mount($id)
    {
        $this->incident_id = $id;
    }
    public function render()
    {
        $this->updatePanel();
        return view('livewire.event-report.incident-report.documentation.index', [
            'IncidentDocumentation' => IncidentDocumentation::where('incident_id', $this->incident_id)->get()
        ]);
    }
    #[On('panel_incident_realtime')]
    public function updatePanel()
    {
        $IncidentReport = IncidentReport::whereId($this->incident_id)->first();
        $this->current_step = $IncidentReport->WorkflowDetails->name;
    }
    public function download(IncidentDocumentation $id)
    {
        $name = $id->name_doc;
        return response()->download(public_path('storage/documents/incident_doc/' .  $name));
    }
    public function destroy($id)
    {
        $files = IncidentDocumentation::whereId($id);
        $files->first()->name_doc;
        unlink(storage_path('app/public/documents/incident_doc/' . $files->first()->name_doc));
        $this->dispatch(
            'alert',
            [
                'text' => "file has been deleted!!",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #ff3333, #ff6666)",
            ]
        );
        $files->delete();
    }
}
