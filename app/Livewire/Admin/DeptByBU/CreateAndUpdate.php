<?php

namespace App\Livewire\Admin\DeptByBU;

use Livewire\Component;
use App\Models\DeptByBU;
use App\Models\Department;
use App\Models\BusinesUnit;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    #[Validate]
    public $busines_unit_id, $department_id, $deptByBU_id, $divider;

  
    public function mount(BusinesUnit $bu, Department $dept)
    {
        if ( $bu->id && $dept->id) {
            $this->deptByBU_id = DeptByBU::where('busines_unit_id', $bu->id)->where('department_id',$dept->id)->first()->id;
            $this->busines_unit_id = $bu->id;
            $this->department_id = $dept->id;
        }
    }
    public function render()
    {
        if ($this->deptByBU_id) {
            $this->divider = "Edit Data";
        } else {
            $this->divider = "Add Data";
        }
        
        return view('livewire.admin.dept-by-b-u.create-and-update',[
            'BusinesUnit' => BusinesUnit::with('Company')->get(),
            'Department' => Department::get()
        ]);
    }
    public function rules()
    {
        return [
            'busines_unit_id' => ['required'],
            'department_id' => ['required',]
        ];
    }
    public function messages()
    {
        return [
            'busines_unit_id.required' => 'The Group Name fild is required.',
            'department_id.required' => 'The Department Name fild is required.',
        ];
    }
    public function store()
    {
        $this->validate();
        DeptByBU::updateOrCreate(
            ['id' => $this->deptByBU_id],
            [
                'busines_unit_id' => $this->busines_unit_id,
                'department_id' => $this->department_id,

            ]
        );
        if ($this->deptByBU_id) {
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
            $this->reset('department_id');
        }
        $this->dispatch('deptByBU_created');
    }
    public function emptyFilds()
    {
        $this->reset('busines_unit_id');
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
