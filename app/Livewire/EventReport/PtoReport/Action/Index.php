<?php

namespace App\Livewire\EventReport\PtoReport\Action;

use Livewire\Component;
use App\Models\ObserverAction;
use App\Models\User;
use Cjmellor\Approval\Models\Approval;

class Index extends Component
{
    public $reference,$show=false;
    public function mount($reference)
    {
        $this->reference = $reference;
    }
    protected $listeners = [

        'action_pto' => 'render'
    ];
    public function render()
    {
        if ($this->reference) {
            $action = Approval::where('new_data->reference', 'like', $this->reference)->count('new_data->action');
            if ($action>0) {
                $this->show=true;
            } else {
                $this->show=false;
            }
            $source = Approval::where('new_data->reference', 'like', $this->reference)->whereNotNull('new_data->action')->paginate(10);
        } else {
            $source = Approval::paginate(100);
        }
        return view('livewire.event-report.pto-report.action.index', [
            "Action_PTO" => $source,
            
        ]);
    }
    public function paginationView()
    {
        return 'pagination.masterpaginate';
    }
    public function delete($id)
    {
        Approval::where('id', $id)->delete();
    }
}
