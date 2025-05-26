<?php

namespace App\Livewire\Admin\EventCategory;

use Livewire\Component;
use App\Models\EventCategory;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search='';
    protected $listeners = ['event_category_created' => 'render'];

    public function render()
    {
        return view('livewire.admin.event-category.index',[
            'EventCategory' => EventCategory::searchData(trim($this->search))->paginate(20),
        ])->extends('base.index', ['header' => 'Event Category', 'title' => 'Event Category'])->section('content');
    }
    public function updateData($id)
    {

        $this->dispatch('event_category_updated', $id);
    }
    public function delete($id)
    {
        $deleteFile = EventCategory::whereId($id);
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
