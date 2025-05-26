<?php

namespace App\Livewire\Admin\EventSubType;

use App\Models\Eventsubtype;
use App\Models\TypeEventReport;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search='';
    public $searchEventSubtipe;
    protected $listeners = ['event_sub_type_created' => 'render'];
    public function render()
    {
        return view('livewire.admin.event-sub-type.index',[
            'EventType' => TypeEventReport::get(),
            'EventSubType' => Eventsubtype::searchData(trim($this->search))->searchEventSubtipe(trim($this->searchEventSubtipe))->paginate(20)
        ])->extends('base.index', ['header' => 'Event Subtype', 'title' => 'Event Subtype'])->section('content');
    }
    public function updateData($id)
    {

        $this->dispatch('eventSubtip_update', $id);
    }
    public function delete($id)
    {
        $deleteFile = Eventsubtype::whereId($id);
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

    public function paginationView()
    {
        return 'pagination.masterpaginate';
    }
}
