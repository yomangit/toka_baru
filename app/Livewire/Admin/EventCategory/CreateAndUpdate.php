<?php

namespace App\Livewire\Admin\EventCategory;

use App\Models\EventCategory;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    public $event_category_name,$event_category_id;
    public $divider;
    public function mount(EventCategory $event_category){
        $this->event_category_id = $event_category->id;
        $this->event_category_name = $event_category->event_category_name;
    }
    public function render()
    {
        if ($this->event_category_id) {
            $this->divider ="Edit Event Category";
        } else {
            $this->divider ="Add Event Category";
        }
        return view('livewire.admin.event-category.create-and-update');
    }
    public function rules(){
        return [
            'event_category_name' =>'required',
        ];
    }
    public function messages(){
        return [
            'event_category_name.required' => 'Event category name is required',
        ];
    }
    public function store(){
        $this->validate();
        EventCategory::updateOrCreate([
            'id' => $this->event_category_id,
        ],[
            'event_category_name' => $this->event_category_name
        ]);
        if ($this->event_category_id) {
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
            $this->reset('event_category_name');
        }
        $this->dispatch('event_category_created');
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
