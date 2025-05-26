<?php

namespace App\Livewire\Admin\ChoseEventType;

use App\Models\choseEventType;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['chose_eventType_create' => 'render'];
    public function render()
    {
        return view('livewire.admin.chose-event-type.index',[
            'Chose_eventType' => choseEventType::with('eventType')->orderBy('route_name','ASC')->paginate(15)
        ])->extends('base.index', ['header' => 'Chose Event Type', 'title' => 'Chose Event Type'])->section('content');
    }
}
