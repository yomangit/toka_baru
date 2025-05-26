<?php

namespace App\Livewire\Admin\People;

use Livewire\Component;
use App\Models\User;
class Show extends Component
{
    public $user_id;
    public function mount(User $id)
    {
        $this->user_id = $id->id;
    }
    public function render()
    {
        return view('livewire.admin.people.show')->extends('base.index', ['header' => 'People', 'title' => 'People'])->section('content');
    }
}
