<?php

namespace App\Livewire\Admin\People;

use Livewire\Component;
use App\Models\User;
use App\Models\ActionIncident;
use App\Models\IncidentReport;
use Livewire\WithPagination;
class Event extends Component
{
    use WithPagination;
    public $user_id;
    public function mount(User $user_id)
    {
        $this->user_id = $user_id->id;
    }
    public function render()
    {
      
        return view('livewire.admin.people.event',[
            'IncidentAction' => ActionIncident::get(),
            'IncidentReport' => IncidentReport::with([
                'WorkflowDetails',
                'subEventType',
                'eventType',
            ])->searchUser(trim($this->user_id))->paginate(30)
            ]);
    }
}
