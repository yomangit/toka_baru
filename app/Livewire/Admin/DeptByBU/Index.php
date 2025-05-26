<?php

namespace App\Livewire\Admin\DeptByBU;

use Livewire\Component;
use App\Models\DeptByBU;
use App\Models\BusinesUnit;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search='';
    protected $listeners = [
        'deptByBU_created' => 'render',
    ];
    public function render()
    {
        return view('livewire.admin.dept-by-b-u.index', [
            'BusinesUnit' => BusinesUnit::with(['Department','Company'])->paginate(20),
        ])->extends('base.index', ['header' => 'Department Under Business Unit ', 'title' => 'Department Under Business Unit'])->section('content');
    }
   
    public function delete($idBu,$idDept)
    {
        $id =DeptByBU::where('department_id', $idDept)->where('busines_unit_id', $idBu)->first()->id;
        $deleteFile = DeptByBU::whereId($id);
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
