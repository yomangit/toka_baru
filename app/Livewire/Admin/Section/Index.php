<?php

namespace App\Livewire\Admin\Section;

use App\Models\Section;
use Livewire\Component;
use Livewire\WithPagination;
use LivewireUI\Modal\ModalComponent;

class Index extends Component
{
    use WithPagination;
    public $search_name = '';
    protected $listeners = ['section_create' => 'render'];
    public function render()
    {
        return view('livewire.admin.section.index', [
            'Section' => Section::searchName(trim($this->search_name))->orderBy('name','ASC')->paginate(15)
        ])->extends('base.index', ['header' => 'Section', 'title' => 'Section'])->section('content');
    }
  
    public function delete($id)
    {
        $delete = Section::whereId($id);
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
        $delete->delete();
    }
    public function paginationView()
    {
        return 'pagination.masterpaginate';
    }
}
