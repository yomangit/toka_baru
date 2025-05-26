<?php

namespace App\Livewire\Admin\Company;

use App\Models\Company;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Imports\CompanyImport;
use App\Models\CompanyCategory;
use Livewire\Attributes\Validate;
use Maatwebsite\Excel\Facades\Excel;
use LivewireUI\Modal\ModalComponent;
class CreateAndUpdate extends ModalComponent
{
    #[Validate]
    public $name_company, $company_category_id, $company_id, $divider;
    
    public function mount( Company $company)
    {
            $this->company_id = $company->id;
            $this->name_company = $company->name_company;
            $this->company_category_id = $company->company_category_id;
    }
    public function render()
    {
        if ($this->company_id) {
            $this->divider= "Edit Company";
        } else {
            $this->divider= "Add Company";
        }
        return view('livewire.admin.company.create-and-update', [
            'CompanyCategory' => CompanyCategory::get()
        ]);
    }
    public function rules()
    {
        return [
            'name_company' => ['required', 'string', 'min:3', 'max:50'],
            'company_category_id' => ['required',]
        ];
    }
    public function store()
    {
        $this->validate();
        Company::updateOrCreate(
            ['id' => $this->company_id],
            [
                'name_company' => $this->name_company,
                'company_category_id' => $this->company_category_id,
            ]
        );
        if ($this->company_id) {
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
            $this->forceClose()->closeModal();
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
            $this->reset('name_company');
            $this->reset('company_category_id');
        }
        $this->dispatch('company_created');
       
    }
    public static function modalMaxWidth(): string
    {
        return 'md';
    }
    public static function closeModalOnClickAway(): bool
    {
        return false;
    }
}
