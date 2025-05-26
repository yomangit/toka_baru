<?php

namespace App\Livewire\Admin\TypeEventReport;

use Livewire\Attributes\On;
use App\Models\EventCategory;
use App\Models\TypeEventReport;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    public $type_eventreport_name, $event_category_id, $eventTypeReport_id, $divider;

    public function mount(TypeEventReport $event_type)
    {
            $this->eventTypeReport_id = $event_type->id;
            $this->type_eventreport_name = $event_type->type_eventreport_name;
            $this->event_category_id = $event_type->event_category_id;
    }
    public function render()
    {
        if ($this->eventTypeReport_id) {
            $this->divider="Edit Event Type";
        } else {
            $this->divider="Add Event Type";
        }
        return view('livewire.admin.type-event-report.create-and-update',[
            'EventCategory'=>EventCategory::get()
        ]);
    }
    public function rules()
    {
        return [
            'type_eventreport_name' => ['required', 'string', 'min:3', 'max:50'],
            'event_category_id' => ['required',]
        ];
    }
    public function messages(){
        return [
            'type_eventreport_name.required' => 'Type Event Report Name is required',
            'type_eventreport_name.string' => 'Type Event Report Name must be a string',
            'type_eventreport_name.min' => 'Type Event Report Name must be at least 3 characters long',
            'type_eventreport_name.max' => 'Type Event Report Name must be a maximum of 50 characters long',
            'event_category_id.required' => 'Event Category is required',
        ];
    }
    public function store()
    {
        $this->validate();
        TypeEventReport::updateOrCreate(
            ['id' => $this->eventTypeReport_id],
            [
                'type_eventreport_name' => $this->type_eventreport_name,
                'event_category_id' => $this->event_category_id,

            ]
        );
        if ($this->eventTypeReport_id) {
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
            $this->reset('type_eventreport_name');
            $this->reset('event_category_id');
        }
        $this->dispatch('type_eventreport_created');
       
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
