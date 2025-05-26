<?php

namespace App\Livewire\Admin\People;

use App\Models\User;
use App\Models\Company;
use Livewire\Component;
use App\Models\end_date;
use App\Models\Department;
use Livewire\Attributes\On;
use App\Models\RoleUserPermit;
use Livewire\Attributes\Validate;


class CreateAndUpdate extends Component
{
    #[Validate]
    public $id, $name, $email, $password,$import_file, $first_name, $last_name, $lookup_name, $employee_id, $gender, $date_birth, $date_commenced,$end_date, $username, $company_id,$dept_id, $role_user_permit_id,$tanggal,$modal;
    public  $divider = '', $users_id,  $search_company = '';
    #[On('openModalPeople')]
    public function openModalPeople(User $user)
    {
        $this->modal="modal-open";
            if ($user->id) {
            $this->users_id = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->lookup_name = (!empty($user->lookup_name)?$user->lookup_name: strtoupper($this->last_name) . ',' . ucwords($this->first_name));
            $this->employee_id = $user->employee_id;
            $this->first_name = $user->first_name;
            $this->last_name = $user->last_name;
            $this->gender = $user->gender;
            $this->date_birth = $user->date_birth;
            $this->date_commenced = $user->date_commenced;
            $this->username = $user->username;
            $this->company_id = $user->company_id;
            $this->dept_id = $user->department;
            $this->end_date = $user->end_date;
            $this->role_user_permit_id = $user->role_user_permit_id;
            }

    }
    public function rules()
    {
        if (!$this->users_id) {
            return [
               
                'email' => ['nullable', 'email', 'unique:users,email,' . $this->users_id],
                'first_name' => ['nullable', 'string', 'max:255'],  
                'last_name' => ['nullable', 'string', 'max:255'],
                'lookup_name' => ['required', 'string', 'max:255'],
                'employee_id' => ['nullable', 'string', 'max:255'],
                'gender' => ['required', 'string', 'max:255'],
                'date_birth' => ['nullable', 'date'],
                'date_commenced' => ['required', 'date'],
                'username' => ['nullable', 'string', 'max:255', 'unique:users,username,' . $this->users_id],
                'company_id' => ['required'],
                'dept_id' => ['required'],
                'end_date' => ['nullable', 'date'],
                'role_user_permit_id' => ['required'],
                
            ];
        }else{
            return [
               
                'lookup_name' => ['required', 'string', 'max:255'],
                'employee_id' => ['required', 'string', 'max:255'],
                'gender' => ['required', 'string', 'max:255'],
                'date_birth' => ['nullable', 'date'],
                'date_commenced' => ['required', 'date'],
                'username' => ['nullable', 'string', 'max:255', 'unique:users,username,' . $this->users_id],
                // 'dept_id' => ['required'],
                // 'end_date' => ['required', 'date'],
                'company_id' => ['required'],
                'role_user_permit_id' => ['required'],
                
            ];
        }
    }
    public function messages()
    {
        return [
           
            'email.required' => 'The Email field is required.',
            'email.email' => 'The Email field must be a valid email address.',
            'email.unique' => 'The Email has already been taken.',
            'first_name.required' => 'The First Name field is required.',
            'last_name.required' => 'The Last Name field is required.',
            'lookup_name.required' => 'The Lookup Name field is required.',
            'employee_id.required' => 'The Employee ID field is required.',
            'gender.required' => 'The Gender field is required.',
            'date_birth.required' => 'The Date of Birth field is required.',
            'date_birth.date' => 'The Date of Birth field must be a valid date.',
            'date_commenced.required' => 'The Date Commenced field is required.',
            'date_commenced.date' => 'The Date Commenced field must be a valid date.',
            'end_date.required' => 'The fild field is required.',
            'end_date.date' => 'The fild field must be a valid date.',
            'username.required' => 'The Username field is required.',
            'username.string' => 'The Username field must be a string.',
            'username.max' => 'The Username field must be a maximum of 255 characters long.',
            'username.unique' => 'The Username has already been taken.',
            'company_id.required' => 'The Employer field is required.',
            'dept_id.required' => 'The department field is required.',
            'role_user_permit_id.required' => 'The Role field is required.',
        ];
    }

    public function render()
    {
        if ($this->users_id) {
            $this->tanggal = "tanggal";
            $this->divider="Edit People";
        } else {
            $this->tanggal = "tanggal";
            $this->divider="Add People";
        }
        
        if (!$this->users_id) {     
            $this->lookup_name =  strtoupper($this->last_name) . ',' . ucwords($this->first_name);
        }
        return view('livewire.admin.people.create-and-update', [
            'Company'=>Company::searchCompany(trim($this->search_company))->orderBy('name_company','ASC')->get(),
            'Department'=>Department::searchDepartment(trim($this->search_company))->orderBy('department_name','ASC')->get(),
            "Role"=>RoleUserPermit::get(),
        ])->extends('base.index');
    }
    public function store()
    {
        $this->validate();
        User::updateOrCreate(['id' => $this->users_id], [
            'name' => $this->name,
            'email' => $this->email,
            'lookup_name' => $this->lookup_name,
            'employee_id' => $this->employee_id,
            'gender' => $this->gender,
            'date_birth' => $this->date_birth,
            'date_commenced' => $this->date_commenced,
            'role_user_permit_id' => $this->role_user_permit_id,
            'username' => $this->username,
            'company_id' => $this->company_id,
            'department' => $this->dept_id,
            'end_date' => $this->end_date,
        ]);
        if ($this->users_id) {
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
            $this->closeModal();
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
            $this->resetFilds();
        }
       
        $this->dispatch('people_created');
    }
    /**
     * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
     */
    public  function closeModal()
    {
        $this->reset('modal');
        $this->resetFilds();
    }
   
    public function resetFilds()
    {
        $this->reset('users_id');
        $this->reset('email');
        $this->reset('first_name');
        $this->reset('last_name');
        $this->reset('lookup_name');
        $this->reset('employee_id');
        $this->reset('gender');
        $this->reset('date_birth');
        $this->reset('date_commenced');
        $this->reset('username');
        $this->reset('company_id');
        $this->reset('role_user_permit_id');
    }
}
