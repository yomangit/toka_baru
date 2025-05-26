<?php

namespace App\Livewire\Admin\TableRiskAssessment;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\RiskAssessment;
use App\Models\RiskLikelihood;
use App\Models\RiskConsequence;
use App\Models\TableRiskAssessment;

class CreateAndUpdate extends Component
{
    public $modal = 'modal', $risk_assessment_id, $risk_consequence_id, $risk_likelihood_id,$tableRiskAssessment_id, $divider;

    #[On('tableRiskAssessment_updated')]
    public function updateTableRiskAssessment_updated($id)
    {
        if ($id) {
            $this->tableRiskAssessment_id = $id;
            $TableRiskAssessment = TableRiskAssessment::whereId($id)->first();
            $this->risk_assessment_id = $TableRiskAssessment->risk_assessment_id;
            $this->risk_consequence_id = $TableRiskAssessment->risk_consequence_id;
            $this->risk_likelihood_id = $TableRiskAssessment->risk_likelihood_id;
            $this->modal = 'modal modal-open';
            $this->divider = 'Update Table Risk ';
        }
    }
    public function render()
    {
        return view('livewire.admin.table-risk-assessment.create-and-update',[
            'RiskAssessment' => RiskAssessment::get(),
            'RiskLikelihood' => RiskLikelihood::get(),
            'RiskConsequence' => RiskConsequence::get()
        ]);
    }
    public function rules()
    {
        return [
            'risk_assessment_id' => ['required'],
            'risk_likelihood_id' => ['required'],
            'risk_consequence_id' => ['required',]
        ];
    }
    public function messages()
    {
        return [
            'risk_assessment_id.required' => 'The Risk Assessment Name fild is required.',
            'risk_likelihood_id.required' => 'The Risk Likelihood Name fild is required.',
            'risk_consequence_id.required' => 'The Risk Consequemce Name fild is required.',
        ];
    }
    public function store()
    {
        $this->validate();
        TableRiskAssessment::updateOrCreate(
            ['id' => $this->tableRiskAssessment_id],
            [
                'risk_assessment_id' => $this->risk_assessment_id,
                'risk_likelihood_id' => $this->risk_likelihood_id,
                'risk_consequence_id' => $this->risk_consequence_id,

            ]
        );
        if ($this->tableRiskAssessment_id) {
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
        $this->dispatch('tableRiskAssessment_created');

    }
    public function openModal()
    {
        $this->modal = 'modal modal-open';
        $this->divider = 'Input Department Group';
    }
    public function closeModal()
    {
        $this->emptyFilds();
        $this->modal = 'modal';
    }
    public function emptyFilds()
    {
        $this->reset('tableRiskAssessment_id');
        $this->reset('risk_assessment_id');
        $this->reset('risk_likelihood_id');
        $this->reset('risk_consequence_id');
    }

}
