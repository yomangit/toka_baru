<?php

namespace App\Livewire\Admin\UserInputManhours;

use App\Models\Company;
use App\Models\User;
use App\Models\UserInputManhours;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    public $company_id, $user_id, $user_name, $userInput_id;
    public $divider, $search_people = '';
    public function mount(UserInputManhours $user)
    {
        $this->userInput_id = $user->id;
        if ($this->userInput_id) {
            $this->company_id = $user->company_id;
            $this->user_id = $user->user_id;
            $this->user_name = $user->User->lookup_name;
            $this->search_people = $user->User->lookup_name;
        }
    }
    public function user_input(User $id)
    {
        $this->user_id = $id->id;
        $this->user_name = $id->lookup_name;
    }
    public function rules()
    {
        return [

            'user_name' => 'required',
            'company_id' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'user_name.required' => 'User  fild is required',
            'company_id.required' => 'Company fild is required',
        ];
    }
    public function store()
    {
        $this->validate();
        UserInputManhours::updateOrCreate(
            ['id' => $this->userInput_id],
            [
                'company_id' => $this->company_id,
                'user_id' => $this->user_id,
            ]
        );
        if ($this->userInput_id) {
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
            $this->reset('user_name');
            $this->reset('user_id');
            $this->reset('company_id');
        }
        $this->dispatch('userInput_created');
    }
    public function render()
    {
        if ($this->company_id) {
            $this->divider = "Edit User Input";
        } else {
            $this->divider = "Add User Input";
        }
        return view('livewire.admin.user-input-manhours.create', [
            'Company' => Company::get(),
            'User' => User::searchFor(trim($this->search_people))->paginate(100, ['*'], 'users')
        ]);
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
