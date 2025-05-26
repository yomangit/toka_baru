<?php

namespace App\Livewire\Admin\Workgroup;

use App\Models\Company;
use Livewire\Component;
use App\Models\DeptByBU;
use App\Models\Division;
use App\Models\JobClass;
use App\Models\Workgroup;
use Livewire\Attributes\On;

class CreateAndUpdate extends Component
{
    public $modal = 'modal', $division_id, $job_class_id, $job_class_id_update, $workgroup_id, $divider, $i, $select, $pading,$show=false;
    #[On('Workgroup_updated')]
    public function updateWorkgroup_updated($id)
    {
        if ($id) {
            $this->workgroup_id = $id;
            $Workgroup = Workgroup::whereId($id)->first();
            $this->division_id = $Workgroup->division_id;
            $this->job_class_id_update = $Workgroup->job_class_id;
            $this->modal = 'modal modal-open';
            $this->divider = 'Update Workgroup';
        }
    }
    public function mount()
    {

        $this->select = [];
        $this->job_class_id = [];
        $this->i = 1;
    }
    public function add($i)
    {
        $this->i = $i + 1;
        array_push($this->select, $i);
    }
    function remove($index)
    {
        unset($this->select[$index]);
        $this->select = array_values($this->select);
    }
    public function render()
    {
        if ($this->division_id == 23) {
            $this->show=true;
        }
        else{
            $this->show=false;
        }
        return view('livewire.admin.workgroup.create-and-update', [
           'Division' =>Division::with(['DeptByBU.BusinesUnit.Company','DeptByBU.Department','Company'])->orderBy('division_id','asc')->paginate(20),
            'JobClass' => JobClass::get()
        ]);
    }
  
    public function rules()
    {
        return [
            'division_id' => ['required'],
            'job_class_id' => ['required'],
            'job_class_id.*' => ['required',]
        ];
    }
    public function messages()
    {
        return [
            'division_id.required' => 'The Business Unit fild is required.',
            'job_class_id.required' => 'The Job Class fild is required.',
            'job_class_id.*.required' => 'The Job Class fild is required.',
        ];
    }
    public function store()
    {
        $this->validate();

        if ($this->workgroup_id) {
            Workgroup::whereId($this->workgroup_id)->update(
                [
                    'division_id' => $this->division_id,
                    'job_class_id' => $this->job_class_id_update,
                ]
            );
        } else {
            foreach ($this->job_class_id as $key => $value) {
                Workgroup::create(
                    [
                        'division_id' => $this->division_id,
                        'job_class_id' => $this->job_class_id[$key],
                    ]
                );
                $this->job_class_id[$key] =null;
            }
           
           
        }
        $this->dispatch('workgroup_created');
        if ($this->workgroup_id) {
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
        }
       
    }
    public function openModal()
    {
        $this->modal = 'modal modal-open';
        $this->divider = 'Input Workgroup';
    }
    public function closeModal()
    {
        $this->modal = 'modal';
        $this->reset('workgroup_id');
        $this->reset('job_class_id');
        $this->select=[];
        $this->job_class_id=[];
    }
}
