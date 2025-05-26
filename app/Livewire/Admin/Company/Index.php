<?php

namespace App\Livewire\Admin\Company;

use App\Models\Company;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CompanyCategory;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    public $search_companty_category = '';
    protected $listeners = [
        'company_created' => 'render',
        'import_company' => 'render',
    ];
    public function render()
    {
        return view('livewire.admin.company.index', [
            'Company' => Company::with(['CompanyCategory'])->searchCompanyCategory(trim($this->search_companty_category))->searchCompany(trim($this->search))->paginate(20),
            'CompanyCategory' => CompanyCategory::get()
        ])->extends('base.index', ['header' => 'Company', 'title' => 'Company'])->section('content');
    }
    public function updateData($id)
    {

        $this->dispatch('company_updated', $id);
    }
    public function delete($id)
    {
        $deleteFile = Company::whereId($id);
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
