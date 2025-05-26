<?php

namespace App\Livewire\EventReport\HazardReport\Action;

use DateTime;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ActionHazard;
use App\Models\HazardReport;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    public $hazard_id, $task_being_done, $orginal_due_date,$current_step;
    protected $listeners = [
        'actionHazard_created' => 'render',
    ];
    public function mount($id)
    {
        $this->hazard_id = $id;
        $Hazard = HazardReport::where('id', $this->hazard_id)->first();
        $this->task_being_done = $Hazard->task_being_done;
        $this->orginal_due_date = DateTime::createFromFormat('Y-m-d : H:i', $Hazard->date)->format('d-m-Y');
    }
    public function render()
    {
        $this->updatePanel();
        return view('livewire.event-report.hazard-report.action.index', [
            'ActionHazard' => ActionHazard::searchHazard(trim($this->search))->where('hazard_id', $this->hazard_id)->with('users')->paginate(20)
        ]);
    }
    #[On('panel_hazard')]
    public function updatePanel()
    {
        $HazardReport = HazardReport::whereId($this->hazard_id)->first();
        $this->current_step = $HazardReport->WorkflowDetails->name;
    }
    public function updateData($id)
    {
        $this->dispatch('action_hazard_update', $id);
    }
    public function delete($id)
    {
        $deleteFile = ActionHazard::whereId($id);
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
