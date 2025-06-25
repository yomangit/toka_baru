<?php

namespace App\Livewire\EventReport\HazardReport;

use Livewire\Component;
use App\Models\ActionHazard;
use App\Models\HazardReport;

class TableExcel extends Component
{
    public function render()
    {
        return view('livewire.event-report.hazard-report.table-excel',[
            'HazardReport'=> HazardReport::with(['reportBy','subEventType','eventType'])->orderBy('date', 'desc')->get(),
            'ActionHazard' => ActionHazard::get(),
        ])->extends('base.web_table')->section('content');
    }
}
