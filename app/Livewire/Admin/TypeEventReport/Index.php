<?php

namespace App\Livewire\Admin\TypeEventReport;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EventCategory;
use App\Models\TypeEventReport;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    public $search_event_category = '';
    protected $listeners = ['type_eventreport_created' => 'render'];
    public function render()
    {
        return view('livewire.admin.type-event-report.index',[
            'EventCategory'=>EventCategory::get(),
            'EventTypeReport'=>TypeEventReport::with('EventCategory')->searchEventType(trim($this->search))->searchEventCategory(trim($this->search_event_category))->paginate(20)
        ])->extends('base.index', ['header' => 'Event Type Report', 'title' => 'Event Type Report'])->section('content');
    }
    public function delete($id)
    {
        $deleteFile = TypeEventReport::whereId($id);
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
