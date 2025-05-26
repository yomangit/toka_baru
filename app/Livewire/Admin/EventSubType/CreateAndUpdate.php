<?php

namespace App\Livewire\Admin\EventSubType;


use App\Models\Eventsubtype;
use App\Models\TypeEventReport;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    public $event_sub_type_name, $event_type_id, $event_subtype_id, $divider;
    public function mount(Eventsubtype $event_sub_type)
    {
            $this->event_subtype_id = $event_sub_type->id;
            $this->event_sub_type_name = $event_sub_type->event_sub_type_name;
            $this->event_type_id = $event_sub_type->event_type_id;
    }

    public function render()
    {
        if ($this->event_subtype_id) {
            $this->divider="Edit Event Sub Type";
        } else {
            $this->divider="Add Event Sub Type";
        }
        return view('livewire.admin.event-sub-type.create-and-update', [
            'event_type' => TypeEventReport::get()
        ]);
    }
    public function rules()
    {
        return [
            'event_sub_type_name' => 'required',
            'event_type_id' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'event_sub_type_name.required' => 'Event Subtype Name is required',
            'event_type_id.required' => 'Event Type is required'
        ];
    }
    public function store()
    {
        $this->validate();
        EventSubtype::updateOrCreate([
            'id' => $this->event_subtype_id
        ], [
            'event_sub_type_name' => $this->event_sub_type_name,
            'event_type_id' => $this->event_type_id
        ]);
        if ($this->event_subtype_id) {
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

            $this->reset('event_sub_type_name');
        }
        $this->dispatch('event_sub_type_created');
    }
    public function emptyData()
    {
        $this->event_subtype_id = null;
        $this->event_sub_type_name = null;
        $this->event_type_id = null;
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
