<?php

namespace App\Livewire\EventReport\PtoReport\Documentation;

use Livewire\Component;
use Cjmellor\Approval\Models\Approval;

class Index extends Component
{
    public $reference,$show=false;
    public function mount($reference)
    {
        $this->reference = $reference;
    }
    protected $listeners = [
        'documents_pto_created' => 'render'
    ];
    public function render()
    {
        
        if ($this->reference) {
            $action = Approval::where('new_data->reference', 'like', $this->reference)->count('new_data->name');
            if ($action>0) {
                $this->show=true;
            } else {
                $this->show=false;
            }
            $source = Approval::where('new_data->reference', 'like', $this->reference)->whereNotNull('new_data->name_doc')->paginate(10);
        } else {
            $source = Approval::paginate(100);
        }
        return view('livewire.event-report.pto-report.documentation.index',[
            'Doc_Pto'=>$source
        ]);
    }
    public function download($id)
    {
        $name = Approval::whereId($id)->first()->new_data['name_doc'];
        return response()->download(storage_path('app/public/documents/pto/' . $name));
    }
    public function destroy($id)
    {
        $files = Approval::whereId($id);
        $files->first()->new_data['name_doc'];
        unlink(storage_path('app/public/documents/pto/' .  $files->first()->new_data['name_doc']));
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
