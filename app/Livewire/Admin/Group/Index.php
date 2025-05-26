<?php

namespace App\Livewire\Admin\Group;

use App\Models\Group;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';

    protected $listeners = ['group_created' => 'render'];
    public function render()
    {
        return view('livewire.admin.group.index', [
            'Group' => Group::searchGroup(trim($this->search))->paginate(10)
        ]);
    }
    public function updateData($id)
    {

        $this->dispatch('group_updated', $id);
    }
    public function delete($id)
    {
        $deleteFile = Group::whereId($id);
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
