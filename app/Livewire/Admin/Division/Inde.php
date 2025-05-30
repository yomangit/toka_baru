<?php

namespace App\Livewire\Admin\Division;

use App\Models\BusinesUnit;
use App\Models\ClassHierarchy;
use App\Models\CompanyCategory;
use App\Models\DeptByBU;
use Livewire\Component;
use App\Models\Division;
use Livewire\WithPagination;

class Inde extends Component
{
    protected $listeners = ['division_create' => 'render'];
    public $show = false, $search;
    public $divisi_id,  $company_category_id, $busines_unit_id, $dept_by_business_unit_id, $heararcy_id;
    use WithPagination;

    public function render()
    {
        if ($this->divisi_id) {
            $ClassHierarchy = ClassHierarchy::with(['Company', 'BusinesUnit.Company', 'DeptByBU.BusinesUnit.Company', 'DeptByBU.Department'])->where('division_id', $this->divisi_id)->first();
            if ($ClassHierarchy) {
                $this->heararcy_id = $ClassHierarchy->id;
                $this->company_category_id = $ClassHierarchy->company_category_id;
                $this->busines_unit_id = $ClassHierarchy->busines_unit_id;
                $this->dept_by_business_unit_id = $ClassHierarchy->dept_by_business_unit_id;
            } else {
                $this->heararcy_id = null;
                $this->reset(['company_category_id', 'busines_unit_id', 'dept_by_business_unit_id']);
            }
        }
        if (Division::whereNotNull('company_id')->exists()) {
            $division = Division::with(['DeptByBU.BusinesUnit.Company', 'DeptByBU.Department', 'Company', 'Section'])->orderBy('dept_by_business_unit_id', 'asc')->searchDeptCom(trim($this->search))->orderBy('company_id', 'asc')->paginate(20);
        } else {
            $division = Division::with(['DeptByBU.BusinesUnit.Company', 'DeptByBU.Department', 'Company', 'Section'])->searchDeptCom(trim($this->search))->orderBy('dept_by_business_unit_id', 'asc')->paginate(20);
        }

        return view('livewire.admin.division.inde', [
            'Division' => $division,
            'Company' => CompanyCategory::get(),
            'BusinesUnit' => BusinesUnit::with('Company')->get(),
            'Department' => DeptByBU::with(['BusinesUnit.Company', 'Department'])->get()
        ])->extends('base.index', ['header' => 'Division', 'title' => 'Division'])->section('content');
    }
    public function selectHierarcy($id)
    {
        $this->divisi_id = $id;
    }
    public function change($id)
    {
        $this->show = true;
        $this->heararcy_id = $id;
    }

    public function delete($id)
    {
        $deleteFile = Division::whereId($id);
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


    public function store()
    {

        $this->validate(
            [
                'company_category_id' => 'required',
                // 'divisi_id' => 'required|unique:class_hierarchies,division_id' . $this->divisi_id,
                'busines_unit_id' => 'required',
                'dept_by_business_unit_id' => 'required',
            ],
            [
                'company_category_id.required' => 'company fild is required',
                'divisi_id.required' => 'select division fild is required',
                'divisi_id.unique' => ' division id has already been taken',
                'busines_unit_id.required' => 'select business unit fild is required',
                'dept_by_business_unit_id.required' => 'select depeartment fild is required',
            ]
        );
        ClassHierarchy::updateOrCreate([
            'id' => $this->heararcy_id,
        ], [
            'company_category_id' => $this->company_category_id,
            'division_id' => $this->divisi_id,
            'busines_unit_id' => $this->busines_unit_id,
            'dept_by_business_unit_id' => $this->dept_by_business_unit_id,
        ]);
        if ($this->heararcy_id) {
            $this->dispatch(
                'alert',
                [
                    'text' => "Data has been updated",
                    'duration' => 3000,
                    'destination' => '/contact',
                    'newWindow' => true,
                    'close' => true,
                    'backgroundColor' => "linear-gradient(to right, #00b09b, #96c93d)",
                ]
            );
        } else {
            $this->dispatch(
                'alert',
                [
                    'text' => "Data added Successfully!!",
                    'duration' => 3000,
                    'destination' => '/contact',
                    'newWindow' => true,
                    'close' => true,
                    'backgroundColor' => "linear-gradient(to right, #00b09b, #96c93d)",
                ]
            );
        }
        $this->reset(['company_category_id', 'busines_unit_id', 'divisi_id', 'dept_by_business_unit_id']);
        $this->show = false;
    }
    public function clear($id)
    {
        $deleteFile = ClassHierarchy::whereId($id);
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
