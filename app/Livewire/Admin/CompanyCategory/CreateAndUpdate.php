<?php

namespace App\Livewire\Admin\CompanyCategory;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\CompanyCategory;
use Livewire\Attributes\Validate;

class CreateAndUpdate extends Component
{
    #[Validate]
    public $modal = 'modal', $name_category_company, $company_category_id, $divider;

    #[On('companyCategory_updated')]
    public function updateCompanyCategory_updated($id)
    {
        if ($id) {
            $this->company_category_id = $id;
            $company_category = CompanyCategory::whereId($id)->first();
            $this->name_category_company = $company_category->name_category_company;
            $this->modal = 'modal modal-open';
            $this->divider = 'Update Company Category';
        }
    }
    public function render()
    {
        return view('livewire.admin.company-category.create-and-update');
    }
    public function rules()
    {
        return [
            'name_category_company' => ['required', 'string', 'min:2', 'max:50']
        ];
    }

    public function store()
    {
        $this->validate();
        CompanyCategory::updateOrCreate(
            ['id' => $this->company_category_id],
            ['name_category_company' => $this->name_category_company]
        );
        if ($this->company_category_id) {
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
            $this->reset('name_category_company');
        }
        $this->dispatch('companyCategory_created');
       
    }

    public function openModal()
    {
        $this->modal = 'modal modal-open';
        $this->divider = 'Input Company Category';
    }
    public function closeModal()
    {
        $this->reset('name_category_company');
        $this->reset('company_category_id');
        $this->modal = 'modal';
    }
}
