<?php

namespace App\Livewire\Manhours;

use App\Models\Company;
use Livewire\Component;
use App\Models\Manhours;
use App\Models\Department;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Exports\ManhoursExport;
use App\Models\CompanyCategory;
use App\Models\UserInputManhours;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    #[Url]
    public ?string $search = '', $search_companyCategory = '', $search_name_company = '', $search_department = '';
    public $seleted_manhours = [], $selectAll, $bulkDisable = false, $show = false, $companyID;
    public $tglMulai, $tglAkhir, $rangeDate = '';
    protected $listeners = [
        'manhours_upload' => 'render',
        'manhours_created' => 'render',
    ];
    use WithPagination;
    public function render()
    {


        $this->companyID = UserInputManhours::where('user_id', Auth::user()->id)->get()->pluck('Company.name_company');
        if ($this->rangeDate) {
            if (Auth::user()->role_user_permit_id == 1) {
                $manhours = Manhours::searchCompanyCategory(trim($this->search_companyCategory))->searchDepartment(trim($this->search_department))->whereBetween('date', array([$this->tglMulai, $this->tglAkhir]))->searchCompany(trim($this->search_name_company))->orderBy('created_at', 'desc')->orderBy('date', 'desc')->paginate(30);
            } else {
                $manhours = Manhours::whereIn('company', $this->companyID)->searchCompanyCategory(trim($this->search_companyCategory))->searchDepartment(trim($this->search_department))->whereBetween('date', array([$this->tglMulai, $this->tglAkhir]))->searchCompany(trim($this->search_name_company))->orderBy('date', 'desc')->paginate(30);
            }
        } else {
            if (Auth::user()->role_user_permit_id == 1) {
                $manhours = Manhours::searchManhours(trim($this->search))->searchCompanyCategory(trim($this->search_companyCategory))->searchCompany(trim($this->search_name_company))->searchDepartment(trim($this->search_department))->orderBy('date', 'desc')->paginate(30);
            } else {
                $manhours = Manhours::whereIn('company', $this->companyID)->searchCompanyCategory(trim($this->search_companyCategory))->searchCompany(trim($this->search_name_company))->searchDepartment(trim($this->search_department))->orderBy('date', 'desc')->paginate(30);
                # code...
            }
        }
        $this->updateCount();
        $this->bulkDisable = count($this->seleted_manhours) <= 2;
        return view('livewire.manhours.index', [
            'Manhours' => $manhours,
            'CompanyCategory' => CompanyCategory::get(),
            'Company' => Company::searchCompanyCategory(trim($this->search_companyCategory))->orderBy('name_company', 'ASC')->get(),
            'Department' => Department::orderBy('department_name', 'ASC')->get()
        ])->extends('base.index', ['header' => 'Manhours Register', 'title' => 'Manhours Register'])->section('content');
    }
    public function updateCount()
    {
        if ($this->rangeDate) {
            $main = Manhours::searchCompanyCategory(trim($this->search_companyCategory))->searchDepartment(trim($this->search_department))->whereBetween('date', array([$this->tglMulai, $this->tglAkhir]))->searchCompany(trim($this->search_name_company))->orderBy('date', 'desc')->pluck('id');
        } else {
            $main = Manhours::searchCompanyCategory(trim($this->search_companyCategory))->searchDepartment(trim($this->search_department))->searchCompany(trim($this->search_name_company))->orderBy('date', 'desc')->pluck('id');
        }
        if (count($main) <= 2000) {
            $this->show = count($main) <= 2000;
        } else {
            $this->show = false;
        }
    }
    public function updateData($id)
    {
        $this->dispatch('manhours_updated', $id);
    }
    public function delete($id)
    {
        $deleteFile = Manhours::whereId($id);
        $deleteFile->delete();
        $this->dispatch(
            'alert',
            [
                'text' => "data successfully deleted!!",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #ff3333, #ff6666)",
            ]
        );
    }
    public function updatedSelectAll($value)
    {
        set_time_limit(300);
        if ($this->rangeDate) {
            $main = Manhours::searchManhours(trim($this->search))->searchCompanyCategory(trim($this->search_companyCategory))->searchDepartment(trim($this->search_department))->whereBetween('date', array([$this->tglMulai, $this->tglAkhir]))->searchCompany(trim($this->search_name_company))->orderBy('date', 'desc')->pluck('id');
        } else {
            $main = Manhours::searchManhours(trim($this->search))->searchCompanyCategory(trim($this->search_companyCategory))->searchDepartment(trim($this->search_department))->searchCompany(trim($this->search_name_company))->orderBy('date', 'desc')->pluck('id');
        }

        if ($value) {
            $this->seleted_manhours = $main;
        } else {
            $this->seleted_manhours = [];
        }
    }
    public function export()
    {
        //return (new ManhoursExport($this->seleted_manhours))->download("manhours.xlsx");
        return (new ManhoursExport($this->seleted_manhours))->download('manhours.xlsx');
    }
    public function deleteAll()
    {
        $main = Manhours::searchManhours(trim($this->search))->whereIn('id', $this->seleted_manhours)->pluck('id');
        $this->seleted_manhours = $main;
        try {
            Manhours::whereIn('id', $this->seleted_manhours)->delete();
            $this->dispatch(
                'alert',
                [
                    'text' => "data successfully deleted!!",
                    'duration' => 3000,
                    'destination' => '/contact',
                    'newWindow' => true,
                    'close' => true,
                    'backgroundColor' => "linear-gradient(to right, #ff3333, #ff6666)",
                ]
            );
        } catch (\Exception $e) {
            $this->dispatch(
                'alert',
                [
                    'text' => "Something goes wrong!!",
                    'duration' => 3000,
                    'destination' => '/contact',
                    'newWindow' => true,
                    'close' => true,
                    'backgroundColor' => "linear-gradient(to right, #ff3333, #ff6666)",
                ]
            );
        }
    }
    public function paginationView()
    {
        return 'pagination.masterpaginate';
    }
}
