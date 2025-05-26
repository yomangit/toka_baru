<?php

namespace App\Livewire\Admin\Site;

use App\Models\Site;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    public $site_name, $site_id, $divider;
    public function mount( Site $site){
            $this->site_id = $site->id;
            $this->site_name = $site->site_name;
    }
    
    public function render()
    {
        if ($this->site_id) {
            $this->divider="Edit Site";
        } else {
            $this->divider="Add Site";
        }
        
        return view('livewire.admin.site.create-and-update');
    }
    public function rules(){
        return [
           'site_name' =>'required',
        ];
    }
    public function messages(){
        return [
           'site_name.required' => 'Site Name is required',
        ];
    }
    public function store(){
      Site::updateOrCreate([
        'id' => $this->site_id,  // if site_id exists, update, else insert a new site.
      ],[
        'site_name' => $this->site_name,
      ]);
      if ($this->site_id) {
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
        $this->reset('site_name');
    }
    $this->dispatch('site_created');
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
