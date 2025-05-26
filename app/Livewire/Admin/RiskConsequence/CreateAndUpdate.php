<?php

namespace App\Livewire\Admin\RiskConsequence;

use App\Models\RiskConsequence;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    
    public $risk_consequence_name, $description, $risk_consequence_id, $divider;
    public function mount(RiskConsequence $Risk_Consequence)
    {
            $this->risk_consequence_id = $Risk_Consequence->id;
            $this->risk_consequence_name = $Risk_Consequence->risk_consequence_name;
            $this->description = $Risk_Consequence->description;
    }
    public function render()
    {
        if ($this->risk_consequence_id) {
            $this->divider="Edit Risk Consequence";
        } else {
            $this->divider="Add Risk Consequence";
        }
        
        return view('livewire.admin.risk-consequence.create-and-update');
    }
    public function rules()
    {
        return [
            'risk_consequence_name' => ['required'],
            'description' => ['required']
        ];
    }
    public function messages()
    {
        return [
            'risk_consequence_name.required' => 'The  Name fild is required.',
            'description.required' => 'The Description Name fild is required.',
        ];
    }

    public function store()
    {
        $this->validate();
        RiskConsequence::updateOrCreate(
            ['id' => $this->risk_consequence_id],
            [
                'risk_consequence_name' => $this->risk_consequence_name,
                'description' => $this->description,
            ]
        );
        if ($this->risk_consequence_id) {
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
            $this->reset('risk_consequence_name');
            $this->reset('description');
        }
        $this->dispatch('risk_consequence_created');
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
