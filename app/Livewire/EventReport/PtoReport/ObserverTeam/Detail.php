<?php

namespace App\Livewire\EventReport\PtoReport\ObserverTeam;

use App\Models\ObserverTeam;
use App\Models\pto_report;
use Livewire\Component;

class Detail extends Component
{
    protected $listeners = [
        'pto_detail' => 'render',
        'approval_pto' => 'render'
    ];
    public $reference, $show = false,$observer_id,$currentStep,$disable_btn;
    public function mount(pto_report $id)
    {
        $this->reference = $id->reference;
        $this->observer_id = $id->id;
        if ($this->observer_id) {
            $this->show=true;
        }
    }
    public function render()
    {
        $PTO_Report = pto_report::whereId($this->observer_id)->first();
        $this->currentStep = $PTO_Report->WorkflowDetails->name;
        if ($this->currentStep === 'Closed' || $this->currentStep === 'Cancelled') {
            $this->disable_btn = "btn-disabled";
          
        } else {
            $this->reset(['disable_btn']);
        }
        return view('livewire.event-report.pto-report.observer-team.detail', [
            'ObserverTeam' => ObserverTeam::where('reference', 'LIKE', $this->reference)->paginate(10)
        ]);
    }
    public function delete($id)
    {
       $action = ObserverTeam::whereId($id);
        $this->dispatch(
            'alert',
            [
                'text' => "The action has been deleted!!",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #ff3333, #ff6666)",
            ]
        );
        $action->delete();
    }
}
