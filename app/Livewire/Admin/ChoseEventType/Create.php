<?php

namespace App\Livewire\Admin\ChoseEventType;

use App\Models\choseEventType;
use App\Models\EventCategory;
use App\Models\TypeEventReport;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    public $route_name, $event_type_id;
    public $divider, $routeRequets_id;
    public function mount(choseEventType $eventType)
    {
        $this->routeRequets_id = $eventType->id;
        $this->route_name =  $eventType->route_name;
        $this->event_type_id =  $eventType->event_type_id;
    }
    public function rules()
    {
        return [
            'route_name' => ['required'],
            'event_type_id' => ['required'],
        ];
    }
    public function render()
    {
        if ($this->routeRequets_id) {
            $this->divider = "Update Chose Event Type";
        } else {
            $this->divider = "Create Chose Event Type";
        }
        return view('livewire.admin.chose-event-type.create', [
            'Event_Type' => TypeEventReport::get()
        ]);
    }
    public function store()
    {
        $this->validate();
        choseEventType::updateOrCreate(
            ['id' => $this->routeRequets_id],
            [
                'route_name' => $this->route_name,
                'event_type_id' => $this->event_type_id,
            ]
        );
        if ($this->routeRequets_id) {
            $this->dispatch(
                'alert',
                [
                    'text' => "Data Updated Successfully!!",
                    'duration' => 3000,
                    'destination' => '/contact',
                    'newWindow' => true,
                    'close' => true,
                    'backgroundColor' => "linear-gradient(to right, #00b09b, #96c93d)",
                ]
            );
            $this->forceClose()->closeModal();
        } else {
            $this->reset(['route_name', 'event_type_id']);
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
        $this->dispatch('chose_eventType_create');
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
