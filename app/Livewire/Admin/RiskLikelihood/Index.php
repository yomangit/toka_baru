<?php

namespace App\Livewire\Admin\RiskLikelihood;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\RiskLikelihood;

class Index extends Component
{
    use WithPagination;
    public $search = '';
    protected $listeners = [
        'risk_likelihoods_created' => 'render',
    ];
    public function render()
    {
        return view('livewire.admin.risk-likelihood.index',[
            'Risk_like' => RiskLikelihood::searchRisk(trim($this->search))->paginate(25)
        ])->extends('base.index', ['header' => 'Risk Likelihood ', 'title' => 'Risk Likelihood'])->section('content');
    }
   
    public function delete($id)
    {
        $deleteFile = RiskLikelihood::whereId($id);
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
