<?php

namespace App\Livewire\Manhours;

use Livewire\Component;
use App\Models\Manhours;
class WebAccess extends Component
{
    public function render()
    {
        return view('livewire.manhours.web-access',[
            'Manhours'=>Manhours::orderBy('date', 'desc')->get()
            ])->extends('base.web_table')->section('content');
    }
}
