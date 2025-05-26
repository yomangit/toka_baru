<?php

namespace App\Livewire\Admin\ResponsibleRole;

use App\Models\ResponsibleRole;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    protected $listeners = ['responsible_role_create' => 'render'];
    public function render()
    {
        return view('livewire.admin.responsible-role.index',[
            'ResponsibleRole' => ResponsibleRole::paginate(20)
        ])->extends('base.index', ['header' => 'Responsible Role', 'title' => 'Responsible Role'])->section('content');
    }
    public function updateData($id)
    {

        $this->dispatch('updateResponsibleRole', $id);
    }
    public function delete($id)
    {
        $deleteFile = ResponsibleRole::whereId($id);
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
