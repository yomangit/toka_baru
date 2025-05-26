<?php

namespace App\Livewire\Admin\SubConDept;

use App\Models\Company;
use Livewire\Component;
use App\Models\Department;
use App\Models\SubConDept;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search_company = '';
    public $search_dept = '';
    protected $listeners = [
        'deptGroup_created' => 'render',
        'group_created' => 'render'
    ];
    public function render()
    {
        return view('livewire.admin.sub-con-dept.index',[
            'Department' => Department::with('Company')->paginate(20),
            'Company' => Company::get()
        ])->extends('base.index', ['header' => 'Sub-Contractor Department ', 'title' => 'Sub-Contractor Department'])->section('content');
    }
   
    public function delete($idDept,$idCompany)
    {
        $id =SubConDept::where('department_id', $idDept)->where('company_id', $idCompany)->first()->id;
        $deleteFile = SubConDept::whereId($id);
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
