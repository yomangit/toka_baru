<?php

namespace App\Livewire\Admin\SubConDept;

use App\Models\Company;
use App\Models\Department;
use App\Models\SubConDept;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    #[Validate]
    public  $company_id, $department_id, $subConDept_id, $divider;

    
    public function mount(Company $company, Department $dept)
    {
        if ($company->id && $dept->id) {
            $this->subConDept_id =SubConDept::where('department_id',$dept->id)->where('company_id',$company->id)->first()->id;
            $this->company_id = $company->id;
            $this->department_id = $dept->id;
        }
    }
    public function render()
    {
        if ($this->subConDept_id) {
            $this->divider = "Edit Sub Contractor";
        } else {
            $this->divider = "Add Sub Contractor";
        }
        return view('livewire.admin.sub-con-dept.create-and-update',[
            'Company' => Company::get(),
            'Department' => Department::get()
        ]);
    }
    public function rules()
    {
        return [
            'company_id' => ['required'],
            'department_id' => ['required',]
        ];
    }
    public function messages()
    {
        return [
            'company_id.required' => 'The Company Name fild is required.',
            'department_id.required' => 'The Department Name fild is required.',
        ];
    }
    public function store()
    {
        $this->validate();
        SubConDept::updateOrCreate(
            ['id' => $this->subConDept_id],
            [
                'company_id' => $this->company_id,
                'department_id' => $this->department_id,

            ]
        );
        if ($this->subConDept_id) {
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
            $this->reset('subConDept_id');
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
            $this->emptyFilds();
        }
        $this->dispatch('deptGroup_created');

    }
    public function emptyFilds()
    {
        $this->reset('subConDept_id');
        $this->reset('company_id');
        $this->reset('department_id');
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
