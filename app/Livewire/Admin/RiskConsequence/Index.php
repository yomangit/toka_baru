<?php

namespace App\Livewire\Admin\RiskConsequence;

use App\Models\RiskConsequence;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    protected $listeners = [
        'risk_consequence_created' => 'render',
    ];
    public function render()
    {
        return view('livewire.admin.risk-consequence.index',[
            'Risk_con'=>RiskConsequence::searchRiskConsequence(trim($this->search))->paginate(10)
        ])->extends('base.index', ['header' => 'Risk Consequence ', 'title' => 'Risk Consequence'])->section('content');
    }
  
    public function delete($id)
    {
        $deleteFile = RiskConsequence::whereId($id);
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
