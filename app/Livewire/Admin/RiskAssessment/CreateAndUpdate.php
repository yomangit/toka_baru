<?php

namespace App\Livewire\Admin\RiskAssessment;

use App\Models\RiskAssessment;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    public $risk_assessments_name, $notes, $action_days, $coordinator, $reporting_obligation, $colour, $risk_assessments_id, $divider;
    public function mount(RiskAssessment $risk)
    {
        $this->risk_assessments_id = $risk->id;
        $this->risk_assessments_name = $risk->risk_assessments_name;
        $this->notes = $risk->notes;
        $this->action_days = $risk->action_days;
        $this->coordinator = $risk->coordinator;
        $this->reporting_obligation = $risk->reporting_obligation;
        $this->colour = $risk->colour;
    }
    public function render()
    {
        if ($this->risk_assessments_id) {
            $this->divider = "Edit Risk Assemessment";
        } else {
            $this->divider = "Add Risk Assemessment";
        }
        return view('livewire.admin.risk-assessment.create-and-update');
    }
    public function rules()
    {
        return [
            'risk_assessments_name' => ['required'],
            'notes' => ['required'],
            'action_days' => ['required'],
            'coordinator' => ['required'],
            'reporting_obligation' => ['required'],
            'colour' => ['required']
        ];
    }
    public function messages()
    {
        return [
            'risk_assessments_name.required' => 'The  Name fild is required.',
            'notes.required' => 'The Notes  fild is required.',
            'action_days.required' => 'The Action Days fild is required.',
            'coordinator.required' => 'The Coordinator  fild is required.',
            'reporting_obligation.required' => 'The Reporting Obligation  fild is required.',
            'colour.required' => 'The Colour fild is required.',
        ];
    }
    public function store()
    {
        $this->validate();
        RiskAssessment::updateOrCreate(
            ['id' => $this->risk_assessments_id],
            [
                'risk_assessments_name' => $this->risk_assessments_name,
                'notes' => $this->notes,
                'action_days' => $this->action_days,
                'coordinator' => $this->coordinator,
                'reporting_obligation' => $this->reporting_obligation,
                'colour' => $this->colour
            ]
        );
        if ($this->risk_assessments_id) {
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
            $this->emptyFilds();
        }
        $this->dispatch('risk_assessment_created');
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
    public function emptyFilds()
    {
        $this->reset('risk_assessments_name');
        $this->reset('notes');
        $this->reset('action_days');
        $this->reset('coordinator');
        $this->reset('reporting_obligation');
        $this->reset('colour');
        $this->reset('risk_assessments_id');
    }
}
