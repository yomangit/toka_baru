<?php

namespace App\Livewire\Admin\KeywordMaintenance;

use App\Models\KeywordMaintenance;
use Livewire\Component;

class Index extends Component
{
    public $name,$parent_id,$keyword_id;
    public function render()
    {
        $keyword = KeywordMaintenance::whereNull('parent_id')->with('children')->get();
        return view('livewire.admin.keyword-maintenance.index',[
            'Keyword' => $keyword
        ])->extends('base.index', ['header' => 'Keyword Maintenance', 'title' => 'Keyword Maintenance'])->section('content');
    }
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'parent_id' => ['nullable']
        ];
    }
    public function store()
    {
        $this->validate();
        KeywordMaintenance::updateOrCreate(
            ['id' => $this->keyword_id],
            [
                'name' => $this->name,
                'parent_id' => $this->parent_id,
            ]
        );
        if ($this->keyword_id) {
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
            $this->reset('name');
            $this->reset('parent_id');
        }
        $this->dispatch('company_created');
       
    }
}
