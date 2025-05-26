<?php

namespace App\Livewire\Manhours;

use App\Models\Company;
use App\Models\UserInputManhours;
use Livewire\Component;
use App\Models\JobClass;
use App\Models\Manhours;
use App\Models\DeptGroup;
use App\Models\Department;
use Livewire\Attributes\On;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends Component
{
    public $divider, $manhours_id, $Name = 'test';
    public $company_id, $dept_group_id, $number = 'number',$cek;
    public $date, $company, $company_category, $dept_group, $dept, $job_class, $manhours, $manpower, $modal;
    #[On('openModalManhours')]
    public function openModalManhours(Manhours $id)
    {
        $this->modal = "modal-open";
        $this->manhours_id = $id->id;
        if ($this->manhours_id) {
            $Dept = Department::where('department_name', 'like', $id->department)->first()->id;
            $this->company_id = Company::where('name_company', 'like', $id->company)->first()->id;
            $this->dept_group_id = DeptGroup::where('department_id', $Dept)->first()->id;
            $this->date =  date('M-Y',strtotime($id->date));
            $this->job_class = $id->job_class;
            $this->manhours = $id->manhours;
            $this->manpower = $id->manpower;
        }
    }
   
    public function render()
    {
        if ($this->manhours_id) {
            $this->divider="Edit Manhours";
        } else {
            $this->divider="Add Manhours";
        }
        
        if (auth()->user()->role_user_permit_id == 1)
        {
           $company =  Company::get();
        }
        else
        {
            if(UserInputManhours::where('user_id',auth()->user()->id)->exists()){
                 $company_id = UserInputManhours::where('user_id',auth()->user()->id)->pluck('company_id');
                 $company =  Company::whereIn('id',$company_id)->get();
            }else{
                 $company =  Company::whereId(auth()->user()->company_id)->get();
            }
           
        }
        
        $this->views();
        return view('livewire.manhours.create-and-update', [
            'Company' =>  $company,
            'DeptGroup' => DeptGroup::get(),
            'JobClass' => JobClass::get()
        ]);
    }
    public function views()
    {
        if ($this->company_id) {
            $Company = Company::with('CompanyCategory')->where('id', $this->company_id)->first();
            $this->company_category = $Company->CompanyCategory->name_category_company;
            $this->company = $Company->name_company;
        };
        if ($this->dept_group_id) {
            $DeptGroup = DeptGroup::with(['Group', 'Dept'])->where('id', $this->dept_group_id)->first();
            $this->dept_group = $DeptGroup->Group->group_name;
            $this->dept = $DeptGroup->Dept->department_name;
        };
    }
    public function rules()
    {
        return [
            'company_id' => ['required'],
            'dept_group_id' => ['required'],
            'date' => ['required', 'date'],
            'manhours' => ['required', 'numeric'],
            'job_class' => ['required'],
            'manpower' => ['required', 'numeric'],

        ];
        if ($this->files) {
            return [
                'files' => ['required', 'mimes:csv,xlsx', 'max:5000'],  // 5MB limit
            ];
        }
    }
    public function message()
    {
        return [
            'company_id.required' => 'The Company fild is required.',
            'dept_group_id.required' => 'The Department fild is required.',
            'date.required' => 'The Date fild is required.',
            'manhours.required' => 'The Manhours fild is required.',
            'manhours.numeric' => 'The Manhours fild must be numeric.',
            'job_class.required' => 'The Job Class fild is required.',
            'manpower.required' => 'The Manpower fild is required.',
            'manpower.numeric' => 'The Manpower fild must be numeric.',
            'files.required' => 'The file field is required.',
            'files.mimes' => 'The file must be a CSV or xlsx file.',
            'files.max' => 'The file size must not exceed 5MB.',
        ];
    }

    public function store()
    {
        $this->validate();
        Manhours::updateOrCreate(
            ['id' => $this->manhours_id],
            [
                'date' => date('Y/m/d',strtotime($this->date)),
                'company_category' => $this->company_category,
                'company' => $this->company,
                'department' => $this->dept,
                'dept_group' => $this->dept_group,
                'job_class' => $this->job_class,
                'manhours' => round($this->manhours),
                'manpower' => $this->manpower,
            ]
        );

        if ($this->manhours_id) {
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
              $this->reset([ 'manhours', 'job_class', 'manpower']);
        }
        $this->dispatch('manhours_created');
    }
    //   /**
    //      * Supported: 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
    //      */
    //     public static function modalMaxWidth(): string
    //     {
    //         return 'lg';
    //     }
    public  function closeModal()
    {
        $this->reset(['modal','manhours_id']);
        $this->emptyFilds();
    }
    public function emptyFilds(){
        $this->reset(['company_id', 'dept_group_id', 'date', 'manhours', 'job_class', 'manpower']);
    }
}
