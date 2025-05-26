<?php

namespace App\Livewire\Admin\Location;


use App\Models\LocationEvent;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    public $location_name, $location_id, $divider;

    public function mount(LocationEvent $location)
    {
        $this->location_id = $location->id;
        $this->location_name = $location->location_name;
    }
    public function render()
    {
        if ($this->location_id) {
            $this->divider="Edit Location";
        } else {
            $this->divider="Add Location";
        }
        
        return view('livewire.admin.location.create-and-update');
    }
    public function rules()
    {
        return [
            'location_name' => ['required', 'string', 'min:2', 'max:50']
        ];
    }
    public function messages()
    {
        return [
            'location_name.required' => 'The  Name fild is required.'
        ];
    }

    public function store()
    {
        $this->validate();
        LocationEvent::updateOrCreate(
            ['id' => $this->location_id],
            ['location_name' => $this->location_name]
        );
        if ($this->location_id) {
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
            $this->reset('location_name');
        }
        $this->dispatch('location_created');
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
