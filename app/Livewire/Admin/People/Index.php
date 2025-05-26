<?php

namespace App\Livewire\Admin\People;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    protected $listeners = [
        'import_user' => 'render',
        'people_created' => 'render'
    ];

    public function render()
    {
        return view('livewire.admin.people.index', [
            'People' => User::with(['company','company.CompanyCategory'])->searchFor(trim($this->search))->paginate(20)
        ])->extends('base.index', ['header' => 'People', 'title' => 'People'])->section('content');
    }
    public function updateData($id)
    {

        $this->dispatch('users_update', $id);
    }
    public function delete($id)
    {
        $deleteFile = User::whereId($id);
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
