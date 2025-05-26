<?php

namespace App\Livewire\Admin\Site;

use App\Models\Site;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search='';
    protected $listeners = ['site_created' => 'render'];
    public function render()
    {
        return view('livewire.admin.site.index',[
            'Site' => Site::searchSite(trim($this->search))->paginate(10)
        ])->extends('base.index', ['header' => 'Site', 'title' => 'Site'])->section('content');
    }
   
    public function delete($id){
        $deleteFile = Site::whereId($id);
        $deleteFile->delete();
        $this->dispatch(
            'alert',
            [
                'text' => "Deleted Data Successfully!!",
                'duration' => 3000,
            ]);
    }
}
