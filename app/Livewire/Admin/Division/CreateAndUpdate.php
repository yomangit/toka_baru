<?php

namespace App\Livewire\Admin\Division;

use App\Models\Company;
use App\Models\DeptByBU;
use App\Models\Division;
use App\Models\Section;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    public $divider = '';
    public $dept_by_business_unit_id, $company_id, $division_id, $section_id;

    public function mount(Division $divisi)
    {
        $this->division_id = $divisi->id;
        $this->dept_by_business_unit_id = $divisi->dept_by_business_unit_id;
        $this->company_id = $divisi->company_id;
        $this->section_id = $divisi->section_id;
    }
    public function render()
    {
        if ($this->division_id) {
            $this->divider = "Edit Division";
        } else {
            $this->divider = "Add Division";
        }

        return view('livewire.admin.division.create-and-update', [
            'DeptUnderBU' => DeptByBU::with(['BusinesUnit', 'Department'])->get(),
            'Section' => Section::get(),
            'Company' => Company::where('company_category_id', 2)->get(),
        ]);
    }
    public function rules()
    {
        return [
            'dept_by_business_unit_id' => 'required',
            'section_id' => 'nullable',
            'company_id' => 'nullable',
        ];
    }
    public function messages()
    {
        return [
            'dept_by_business_unit_id.required' => 'Business unit fild is required',
            'section_id.nullable' => 'Section fild is required',
        ];
    }
    public function store()
    {

        $this->validate();
        if ($this->division_id) {
            $this->section_id = ($this->section_id == "null") ? null : $this->section_id;
        }

        Division::updateOrCreate([
            'id' => $this->division_id,
        ], [
            'dept_by_business_unit_id' => $this->dept_by_business_unit_id,
            'company_id' => $this->company_id,
            'section_id' => $this->section_id,
        ]);
        if ($this->division_id) {
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
        }
        $this->reset(['company_id']);
        $this->dispatch('division_create');
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
