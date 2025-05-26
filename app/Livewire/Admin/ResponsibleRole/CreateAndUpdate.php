<?php

namespace App\Livewire\Admin\ResponsibleRole;


use App\Models\ResponsibleRole;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    public $responsible_role_name, $responsible_role_id, $divider;
    public function mount(ResponsibleRole $responsible_Role){
        $this->responsible_role_id = $responsible_Role->id;
        $this->responsible_role_name = $responsible_Role->responsible_role_name;
    }
    public function render()
    {
        if ($this->responsible_role_id) {
            $this->divider="Edit Responsible Role";
        } else {
            $this->divider="Add Responsible Role";
        }
        return view('livewire.admin.responsible-role.create-and-update');
    }
    public function rules(){
        return [
           'responsible_role_name' =>'required',
        ];
    }
    public function messages(){
        return [
           'responsible_role_name.required' => 'Responsible Role Name is required',
        ];
    }
    public function store(){
        $this->validate();
        ResponsibleRole::updateOrCreate(['id' => $this->responsible_role_id], ['responsible_role_name' => $this->responsible_role_name]);
      
        if ($this->responsible_role_id) {
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
            $this->reset('responsible_role_name');
        }
        $this->dispatch('responsible_role_create');
    }
   /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public static function modalMaxWidth(): string
    {
        return 'md';
    }
    public static function closeModalOnClickAway(): bool
    {
        return false;
    }
}
