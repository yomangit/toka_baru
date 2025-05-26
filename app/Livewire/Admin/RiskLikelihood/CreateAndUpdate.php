<?php

namespace App\Livewire\Admin\RiskLikelihood;
use App\Models\RiskLikelihood;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    public $modal = 'modal';
    public $risk_likelihoods_name, $notes, $risk_likelihoods_id, $divider;
    public function mount(RiskLikelihood $risk)
    {
            $this->risk_likelihoods_id = $risk->id;
            $this->risk_likelihoods_name = $risk->risk_likelihoods_name;
            $this->notes = $risk->notes;
    }
    public function render()
    {
        if ($this->risk_likelihoods_id) {
            $this->divider="Edit Risk Likelihoods";
        } else {
            $this->divider="Add Risk Likelihoods";
        }
        
        return view('livewire.admin.risk-likelihood.create-and-update');
    }
    public function rules()
    {
        return [
            'risk_likelihoods_name' => ['required'],
            'notes' => ['required']
        ];
    }
    public function messages()
    {
        return [
            'risk_likelihoods_name.required' => 'The  Name fild is required.',
            'notes.required' => 'The Notes fild is required.',
        ];
    }

    public function store()
    {
        $this->validate();
        RiskLikelihood::updateOrCreate(
            ['id' => $this->risk_likelihoods_id],
            [
                'risk_likelihoods_name' => $this->risk_likelihoods_name,
                'notes' => $this->notes,
            ]
        );
        if ($this->risk_likelihoods_id) {
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
            $this->reset('risk_likelihoods_name');
            $this->reset('notes');
        }
        $this->dispatch('risk_likelihoods_created');
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
