<?php

namespace App\Livewire\Admin\Location;

use App\Models\LocationEvent;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';

    protected $listeners = [
        'location_created' => 'render',
        'import_location'=> 'render'
        ];

    public function render()
    {
        return view('livewire.admin.location.index',[
            'Location'=>LocationEvent::searchFor(trim($this->search))->paginate(20)
        ])->extends('base.index', ['header' => 'Location', 'title' => 'Location'])->section('content');
    }
    public function delete($id)
    {
        $deleteFile = LocationEvent::whereId($id);
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
