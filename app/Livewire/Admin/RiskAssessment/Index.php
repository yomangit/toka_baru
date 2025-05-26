<?php

namespace App\Livewire\Admin\RiskAssessment;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\RiskAssessment;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    protected $listeners = [
        'risk_assessment_created' => 'render',
    ];
    public function render()
    {
        return view('livewire.admin.risk-assessment.index',[
            'Risk_ass' => RiskAssessment::searchRiskAssessment(trim($this->search))->paginate(20)
        ])->extends('base.index', ['header' => 'Risk Assessment ', 'title' => 'Risk Assessment'])->section('content');
    }
    public function delete($id)
    {
        $deleteFile = RiskAssessment::whereId($id);
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
