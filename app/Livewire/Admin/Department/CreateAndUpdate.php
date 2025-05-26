<?php

namespace App\Livewire\Admin\Department;

use App\Models\Department;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    #[Validate]
    public  $department_name, $department_id, $divider;
    public function mount( Department $dept)
    {
       $this->department_id = $dept->id;
       $this->department_name = $dept->department_name;
    }
    public function render()
    {
        if ($this->department_id) {
            $this->divider ="Edit Department";
        } else {
            $this->divider ="Add Department";
        }
        return view('livewire.admin.department.create-and-update');
    }
    public function rules()
    {
        return [
            'department_name' => ['required', 'string', 'min:2', 'max:50']
        ];
    }
    public function store()
    {
        $this->validate();
        Department::updateOrCreate(
            ['id' => $this->department_id],
            ['department_name' => $this->department_name]
        );
        if ($this->department_id) {
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
            $this->reset('department_name');
        }
        $this->dispatch('department_created');
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
