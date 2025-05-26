<?php

namespace App\Livewire\Admin\Group;

use App\Models\Group;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    #[Validate]
    public $group_name, $group_id, $divider;
    public function mount(Group $group)
    {
            $this->group_id = $group->id;
            $this->group_name = $group->group_name;
    }
    public function render()
    {
        if ($this->group_id) {
            $this->divider="Edit Group";
        } else {
            $this->divider="Add Group";
        }
        return view('livewire.admin.group.create-and-update');
    }
    public function rules()
    {
        return [
            'group_name' => ['required', 'string', 'min:2', 'max:50']
        ];
    }
    public function store()
    {
        $this->validate();
        Group::updateOrCreate(
            ['id' => $this->group_id],
            ['group_name' => $this->group_name]
        );
        if ($this->group_id) {
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
            $this->reset('group_name');
        }
        $this->dispatch('group_created');
      
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
