<?php

namespace App\Livewire\Admin\StatusEvent;

use Livewire\Component;
use App\Models\StatusEvent;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    protected $listeners = ['status_created' => 'render'];
    public function render()
    {
        return view('livewire.admin.status-event.index',[
            'StatusEvent' => StatusEvent::searchStatus(trim($this->search))->paginate(20)
        ])->extends('base.index', ['header' => 'Status Event', 'title' => 'Status Event'])->section('content');
    }
    public function delete($id)
    {
        $deleteFile = StatusEvent::whereId($id);
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
