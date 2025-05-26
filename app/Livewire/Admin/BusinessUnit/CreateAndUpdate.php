<?php

namespace App\Livewire\Admin\BusinessUnit;

use App\Models\Company;
use Livewire\Component;
use App\Models\BusinesUnit;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    public $name_company_id, $business_unit_id, $divider = '';

    public function mount(BusinesUnit $bu)
    {
       $this->business_unit_id= $bu->id;
       $this->name_company_id= $bu->name_company_id;
    }
    public function render( )
    {
        if ($this->business_unit_id) {
            $this->divider = "Update Business Unit";
        } else {
            $this->divider = "Create Business Unit";
        }
        return view('livewire.admin.business-unit.create-and-update', [
            'Company' => Company::get()
        ]);
    }
    public function rules()
    {
        return [
            'name_company_id' => ['required']
        ];
    }
    public function store()
    {
        $this->validate();
        BusinesUnit::updateOrCreate(
            ['id' => $this->business_unit_id],
            [
                'name_company_id' => $this->name_company_id,
            ]
        );
        if ($this->business_unit_id) {
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
            $this->forceClose()->closeModal();
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
            $this->reset('name_company_id');
        }
        $this->dispatch('b_unit_created');
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
