<?php

namespace App\Livewire\Admin\DeptGroup;

use App\Models\Group;
use App\Models\DeptGroup;
use App\Models\Department;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    #[Validate]
    public $group_id, $department_id, $deptGroup_id, $divider;
    public function mount(Group $group, Department $dept)
    {
           if ($group->id && $dept->id) {
            $this->deptGroup_id = DeptGroup::where('group_id', $group->id)->where('department_id', $dept->id)->first()->id;
            $this->group_id = $group->id;
            $this->department_id = $dept->id;
           }
    }
    public function render()
    {
        if ($this->deptGroup_id) {
            $this->divider="Edit Dept Group";
        } else {
            $this->divider="Add Dept Group";
        }
        
        return view('livewire.admin.dept-group.create-and-update', [
            'Group' => Group::get(),
            'Department' => Department::get()
        ]);
    }
    public function rules()
    {
        return [
            'group_id' => ['required'],
            'department_id' => ['required',]
        ];
    }
    public function messages()
    {
        return [
            'group_id.required' => 'The Group Name fild is required.',
            'department_id.required' => 'The Department Name fild is required.',
        ];
    }
    public function store()
    {
        $this->validate();
        DeptGroup::updateOrCreate(
            ['id' => $this->deptGroup_id],
            [
                'group_id' => $this->group_id,
                'department_id' => $this->department_id,
            ]
        );
        if ($this->deptGroup_id) {
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
            $this->emptyFilds();
        }
        $this->dispatch('deptGroup_created');
    }
    public function emptyFilds()
    {
        $this->reset('group_id');
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
