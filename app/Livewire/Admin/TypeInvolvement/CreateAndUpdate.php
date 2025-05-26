<?php

namespace App\Livewire\Admin\TypeInvolvement;

use Livewire\Attributes\On;
use App\Models\TypeInvolvement;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    public $data_id,$name, $modal = 'modal',$divider = '';
   
    public function mount(TypeInvolvement $type_involvement)
    {
            $this->data_id = $type_involvement->id;
            $this->name = $type_involvement->name;
    }
    public function render()
    {
        if ($this->data_id) {
           $this->divider = "Edit Type Involvement";
        } else {
           $this->divider = "Add Type Involvement";
        }
        
        return view('livewire.admin.type-involvement.create-and-update');
    }
    public function rules()
    {
        return [
            'name' => ['required']
        ];
    }
    public function store()
    {
        $this->validate();
        TypeInvolvement::updateOrCreate(
            ['id' => $this->data_id],
            [
                'name' => $this->name,
            ]
        );
        if ($this->data_id) {
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
            $this->reset('name');
        }
        $this->dispatch('typeInvolvement__created');
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
