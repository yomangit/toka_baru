<?php

namespace App\Livewire\Admin\BusinessUnit;

use App\Models\Company;
use Livewire\Component;
use App\Models\BusinesUnit;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    protected $listeners = ['b_unit_created' => 'render'];
    public function render()
    {
        return view('livewire.admin.business-unit.index', [
            'Company' => Company::get(),
            'BusinessUnit' => BusinesUnit::with('Company')->search(trim($this->search))->paginate(20)
        ])->extends('base.index', ['header' => 'Business Unit', 'title' => 'Business Unit'])->section('content');
    }
    public function updateData($id)
    {

        $this->dispatch('b_unit_updated', $id);
    }
    public function delete($id)
    {
        $deleteFile = BusinesUnit::whereId($id);
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
