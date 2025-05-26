<?php

namespace App\Livewire\Register;

use Rules\Password;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
class Index extends Component
{
    public $name,$username,$user_id,$email,$password,$password_confirmation;

    public function name_Click(User $id){
        $this->user_id = $id->id;
        $this->name = $id->lookup_name;
        $this->email = $id->email;
        $this->username = $id->username;
    }
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'unique:users,email,' . $this->user_id],
            'username' => ['required'],
            'password' => ['required'],
            'password_confirmation' => ['required_with:password','same:password'],
        ];
    }
    public function store(){
        $this->validate();
        $user = User::updateOrCreate(['id' => $this->user_id], [
          
            'lookup_name' => $this->name,
            'username'=>$this->username,
            'email'=>$this->email,
            'password' => Hash::make($this->password),
        ]);
         event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
    public function render()
    {
        return view('livewire.register.index',[
            'User'=>User::searchNama(trim($this->name))->limit(500)->get()
        ])->extends('base.guest', ['header' => 'Business Unit', 'title' => 'Business Unit'])->section('content');
    }
}
