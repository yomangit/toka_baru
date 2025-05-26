<?php

namespace App\Livewire\Admin\TableRiskAssessment;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\RiskAssessment;
use App\Models\RiskLikelihood;
use App\Models\RiskConsequence;
use App\Models\TableRiskAssessment;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    protected $listeners = [
        'tableRiskAssessment_created' => 'render',
    ];
    public function render()
    {
        return view('livewire.admin.table-risk-assessment.index',[
            'RiskAssessment' => RiskAssessment::get(),
            'RiskConsequence' => RiskConsequence::get(),
            'RiskLikelihood' => RiskLikelihood::searchRisk(trim($this->search))->get(),
        ])->extends('base.index', ['header' => 'Table Risk ', 'title' => 'Table Risk'])->section('content');
    }
    public function editTableRiskAssessment($risk_assessment_id, $risk_consequence_id, $risk_likelihood_id)
    {
        $id = TableRiskAssessment::where('risk_assessment_id', $risk_assessment_id)->where('risk_consequence_id', $risk_consequence_id)->where('risk_likelihood_id', $risk_likelihood_id)->first()->id;
        $this->dispatch('tableRiskAssessment_updated', $id);
    }
    public function deleteTableRiskAssessment($risk_assessment_id, $risk_consequence_id, $risk_likelihood_id)
    {
        $id = TableRiskAssessment::where('risk_assessment_id', $risk_assessment_id)->where('risk_consequence_id', $risk_consequence_id)->where('risk_likelihood_id', $risk_likelihood_id)->first()->id;
        $deleteFile = TableRiskAssessment::whereId($id);
        $this->dispatch(
            'alert',
            [
                'text' => "Deleted Data Successfully!!",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #f97316, #ef4444)",
            ]
        );
        $deleteFile->delete();
    }

    public function paginationView()
    {
        return 'pagination.masterpaginate';
    }
}
