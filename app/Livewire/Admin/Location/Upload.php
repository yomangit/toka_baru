<?php

namespace App\Livewire\Admin\Location;
use App\Imports\LocationImport;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Upload extends ModalComponent
{
    use WithFileUploads;
    #[Validate]
    public $import_file;
     public function rules()
    {
        return [
            'import_file' => 'required|mimes:csv,xlsx',
        ];
    }
    public function message()
    {
        return [
            'import_file.required' => 'The name fild is required.',
            'import_file.mimes' => 'Only csv and xlsx file types are allowed',
        ];
    }
    public function render()
    {
        return view('livewire.admin.location.upload');
    }
    public function store(){
        $this->validate();
        Excel::import(new LocationImport,$this->import_file);
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
        $this->dispatch('import_location');
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
