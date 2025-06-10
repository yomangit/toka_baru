<?php

namespace App\Livewire\EventReport\HazardReportGuest\Action;

use Livewire\Component;
use Cjmellor\Approval\Models\Approval;

class Index extends Component
{
    public $reference, $show = false;
    protected $listeners = [
        'action_hzd' => 'render'
    ];
    public function render()
    {
        if ($this->reference) {
            $action = Approval::where('new_data->reference', 'like', $this->reference)->count('new_data->action');
            if ($action > 0) {
                $this->show = true;
            } else {
                $this->show = false;
            }
            $source = Approval::where('new_data->reference', 'like', $this->reference)->whereNotNull('new_data->action')->paginate(10);
        } else {
            $source = Approval::paginate(100);
        }
        return view('livewire.event-report.hazard-report-guest.action.index', [
            "Action_HZD" => $source,
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
