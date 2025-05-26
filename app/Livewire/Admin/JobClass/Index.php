<?php

namespace App\Livewire\Admin\JobClass;

use App\Models\JobClass;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';

    protected $listeners = ['jobClass_created' => 'render'];
    public function render()
    {
        return view('livewire.admin.job-class.index',[
            'JobClass' =>JobClass::searchFor(trim($this->search))->paginate(20)
        ])->extends('base.index', ['header' => 'Job Class ', 'title' => 'Job Class'])->section('content');
    }
    public function updateData($id)
    {

        $this->dispatch('jobClass_updated', $id);
    }
    public function delete($id)
    {
        $deleteFile = JobClass::whereId($id);
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
