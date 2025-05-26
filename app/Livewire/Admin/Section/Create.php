<?php

namespace App\Livewire\Admin\Section;

use App\Models\Section;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{

    public $name_section,$section_id,$divider;
    public function mount( Section $section)
    {
       $this->section_id = $section->id;
        $this->name_section =  $section->name;
    }
    public function rules()
    {
        return [
            'name_section' => ['required'],
        ];
    }
    public function message()
    {
        return [
            'name_section.required' => 'The name fild is required.',
        ];
    }
    public function render()
    {
        if ($this->section_id) {
            $this->divider = "Update Section";
        } else {
            $this->divider = "Create Section";
        }
        
        return view('livewire.admin.section.create');
    }
    public function store()
    {
        $this->validate();
        Section::updateOrCreate(
            ['id' => $this->section_id],
            [
                'name' => $this->name_section,
            ]
        );
        if ($this->section_id) {
            $this->dispatch(
                'alert',
                [
                    'text' => "Data Updated Successfully!!",
                    'duration' => 3000,
                    'destination' => '/contact',
                    'newWindow' => true,
                    'close' => true,
                    'backgroundColor' => "linear-gradient(to right, #00b09b, #96c93d)",
                ]
            );
            $this->forceClose()->closeModal();
        } else {
            $this->reset('name_section');
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
        }
        $this->dispatch('section_create');
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
}
