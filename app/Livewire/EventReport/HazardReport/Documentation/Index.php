<?php

namespace App\Livewire\EventReport\HazardReport\Documentation;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\HazardReport;
use Livewire\WithPagination;
use App\Models\HazardDocumentation;

class Index extends Component
{
    public $hazard_id, $current_step;
    use WithPagination;
    protected $listeners = [
        'documents_hazard_created' => 'render',
    ];
    public function mount($id)
    {
        $this->hazard_id = $id;
    }
    public function render()
    {
        $this->updatePanel();
        return view('livewire.event-report.hazard-report.documentation.index', [
            'HazardDocumentation' => HazardDocumentation::where('hazard_id', $this->hazard_id)->get()
        ]);
    }
    #[On('panel_hazard')]
    public function updatePanel()
    {
        $HazardReport = HazardReport::whereId($this->hazard_id)->first();
        $this->current_step = $HazardReport->WorkflowDetails->name;
    }
    public function download($id)
    {
        $name = HazardDocumentation::whereId($id)->first()->name_doc;
        return response()->download(storage_path('app/public/documents/hazard/' . $name));
    }
    public function destroy($id)
    {
        $files = HazardDocumentation::whereId($id);
        $files->first()->name_doc;
        unlink(storage_path('app/public/documents/hazard/' . $files->first()->name_doc));
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
