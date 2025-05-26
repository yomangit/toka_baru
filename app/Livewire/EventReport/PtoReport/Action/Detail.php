<?php

namespace App\Livewire\EventReport\PtoReport\Action;

use App\Models\ObserverAction;
use App\Models\pto_report;
use Livewire\Component;

class Detail extends Component
{
    public $reference, $show = false,$action_id,$currentStep,$disable_btn;
 
    public function mount(pto_report $id)
    {
        $this->reference = $id->reference;
        $this->action_id = $id->id;
        if ($this->action_id) {
            $this->show=true;
        }
    }
    protected $listeners = [
        'pto_detail' => 'render',
        'action_pto' => 'render'
    ];
    public function render()
    {
        $PTO_Report = pto_report::whereId($this->action_id)->first();
        $this->currentStep = $PTO_Report->WorkflowDetails->name;
        if ($this->currentStep === 'Closed' || $this->currentStep === 'Cancelled') {
            $this->disable_btn = "btn-disabled";
          
        } else {
            $this->reset(['disable_btn']);
        }
        return view('livewire.event-report.pto-report.action.detail',[
            'ObserverAction' => ObserverAction::where('reference','LIKE', $this->reference)->paginate(10)
        ]);
    }
    public function delete($id)
    {
       $action = ObserverAction::whereId($id);
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
