<?php

namespace App\Livewire\EventReport\PtoReport\Documentation;

use Livewire\Component;
use App\Models\pto_report;
use App\Models\DocumentationOfPto;
use Illuminate\Support\Facades\Storage;

class Detail extends Component
{
    public $reference, $show = false,$currentStep,$disable_btn,$observer_id;
    public function mount(pto_report $id)
    {
        $this->reference = $id->reference;
        $this->observer_id = $id->id;
    }
    protected $listeners = [
        'pto_detail' => 'render',
        'documents_pto_created' => 'render'
    ];
    public function render()
    {
        $PTO_Report = pto_report::whereId($this->observer_id)->first();
        $this->currentStep = $PTO_Report->WorkflowDetails->name;
        if ($this->currentStep === 'Closed' || $this->currentStep === 'Cancelled') {
            $this->disable_btn = "btn-disabled";
          
        } else {
            $this->reset(['disable_btn']);
        }
        return view('livewire.event-report.pto-report.documentation.detail', [
            'Documentation' => DocumentationOfPto::where('reference','LIKE', $this->reference)->paginate(10)
        ]);
    }
    public function download($id)
    {
        $name = DocumentationOfPto::whereId($id)->first()->name_doc;
        return response()->download(storage_path('app/public/documents/pto/' . $name));
    }
    public function destroy($id)
    {
        $files = DocumentationOfPto::whereId($id);
        $files->first()->name_doc;
        $filename = storage_path('app/public/documents/pto/' .   $files->first()->name_doc);
      
        if (file_exists($filename)) {
            unlink(storage_path('app/public/documents/pto/' .   $files->first()->name_doc));
        }
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
