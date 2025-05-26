<?php

namespace App\Livewire\Admin\People;

use App\Imports\PeopleImport;
use Livewire\WithFileUploads;
use LivewireUI\Modal\ModalComponent;
use Maatwebsite\Excel\Facades\Excel;
class Upload extends ModalComponent
{
    public $import_file;
    use WithFileUploads;
    public function render()
    {
        return view('livewire.admin.people.upload');
    }
    public function store(){
        set_time_limit(300);
        $this->validate(['import_file' => 'required']);
        Excel::import(new PeopleImport,$this->import_file);
        $this->dispatch(
            'alert',
            [
                'text' => "Data Imported Successfully!!",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #00b09b, #96c93d)",
            ]
        );
        $this->dispatch('import_user');
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
