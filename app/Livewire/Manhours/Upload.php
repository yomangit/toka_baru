<?php

namespace App\Livewire\Manhours;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\ManhoursImport;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Maatwebsite\Excel\Facades\Excel;

class Upload extends ModalComponent
{
    use WithFileUploads;
    #[Validate]
    public $files;
    public function render()
    {
        return view('livewire.manhours.upload');
    }
    public function rules()
    {
        return [
            'files' => 'required|mimes:csv',
        ];
    }
    public function message()
    {
        return [
            'files.required' => 'The name fild is required.',
            'files.mimes' => 'Only csv file types are allowed',
        ];
    }
    public function store()
    {
        set_time_limit(300);
        $this->validate(['files' => 'required']);
        Excel::import(new ManhoursImport, $this->files);
        session()->flash('success', "importing file has done!!");
        $this->dispatch('manhours_upload');
        $this->dispatch(
            'alert',
            [
                'text' => "Data Upload Successfully!!",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #00b09b, #96c93d)",
            ]
        );
    }
    public static function modalMaxWidth(): string
    {
        return 'md';
    }
    public static function closeModalOnClickAway(): bool
    {
        return false;
    }
}
