<?php

namespace App\Livewire\Admin\UserInputManhours;

use App\Models\UserInputManhours;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    protected $listeners = [
        'userInput_created' => 'render',
    ];
    public function render()
    {
        return view('livewire.admin.user-input-manhours.index',[
          'UserInput' => UserInputManhours::paginate(20)
        ])->extends('base.index', ['header' =>'User Input Manhours', 'title' => ' User Input Manhours'])->section('content');
    }
    public function delete($id)
    {
        $deleteFile = UserInputManhours::whereId($id);
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
