<?php

namespace App\Livewire\Admin\StatusEvent;

use App\Models\StatusEvent;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{

    public $status_name, $bg_status, $status_id, $divider;

   
    public function mount( StatusEvent $status)
    {
            $this->status_id = $status->id;
            $this->status_name = $status->status_name;
            $this->bg_status = $status->bg_status;
           
    }
    public function render()
    {
        if ($this->status_id) {
            $this->divider="Edit Status";
        } else {
            $this->divider="Add Status";
        }
        
        return view('livewire.admin.status-event.create-and-update');
    }
    public function rules()
    {
        return [
            'status_name' => ['required'],
            'bg_status' => ['required']
        ];
    }

    public function store()
    {
        $this->validate();
        StatusEvent::updateOrCreate(
            ['id' => $this->status_id],
            [
                'status_name' => $this->status_name,
                'bg_status' => $this->bg_status
            ]
        );
        if ($this->status_id) {
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
            $this->reset('status_name');
            $this->reset('bg_status');
        }
        $this->dispatch('status_created');
    }

      /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public static function modalMaxWidth(): string
    {
        return 'lg';
    }
    public static function closeModalOnClickAway(): bool
    {
        return false;
    }
}
