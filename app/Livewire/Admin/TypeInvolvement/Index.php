<?php

namespace App\Livewire\Admin\TypeInvolvement;

use Livewire\Component;
use Livewire\Attributes\Url;
use App\Models\TypeInvolvement;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    #[Url] 
    public $search='';
    protected $listeners = ['typeInvolvement__created' => 'render'];
    public function render()
    {
        return view('livewire.admin.type-involvement.index',[
            'Type_Involvement' =>TypeInvolvement::search(trim($this->search))->paginate(20)
        ])->extends('base.index', ['header' => 'Type Involvement', 'title' => 'Type Involvement'])->section('content');
    }
    public function updateData($id){
        $this->dispatch('typeInvolvement_updated',$id);
    }
    public function delete($id)
    {
        $deleteFile = TypeInvolvement::whereId($id);
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

