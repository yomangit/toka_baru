<?php

namespace App\Livewire\EventReport\PtoReport\ObserverTeam;


use Cjmellor\Approval\Models\Approval;

use Livewire\Component;

class Index extends Component
{

    public $reference, $show=false;
    protected $listeners = [

        'approval_pto' => 'render'
    ];
 
    public function mount($reference)
    {
        $this->reference = $reference;
    }
    public function render()
    {
        if ($this->reference) {
            $action = Approval::where('new_data->reference', 'like', $this->reference)->count('new_data->name');
            if ($action>0) {
                $this->show=true;
            } else {
                $this->show=false;
            }
            $source = Approval::where('new_data->reference', 'like', $this->reference)->whereNotNull('new_data->name')->paginate(10);
        } else {
            $source = Approval::paginate(100);
        }
        return view('livewire.event-report.pto-report.observer-team.index', [
            'Approval' => $source
        ]);
    }
    public function delete($id)
    {
      $delete =  Approval::where('id', $id);
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
        $delete->delete();
    }
}
