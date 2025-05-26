<?php

namespace App\Livewire\Admin\EventUserSecurity;

use App\Models\User;
use App\Models\DeptByBU;
use App\Models\Division;
use App\Models\Workgroup;
use App\Models\BusinesUnit;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\ClassHierarchy;
use App\Models\CompanyCategory;
use App\Models\ResponsibleRole;
use App\Models\TypeEventReport;
use App\Models\EventUserSecurity;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    use WithPagination;

    #[Url]
    public $search_people = '';
    public $divider = '', $search_workgroup = '';
    public $responsible_role_id,  $workgroup_name, $user_id = [], $workgroup = [], $type_event_report_id, $event_user_security_id, $user_id_update, $division_id, $parent_Company, $business_unit, $dept;
    public function mount(EventUserSecurity $user_security)
    {
        $this->event_user_security_id = $user_security->id;
        $this->responsible_role_id = $user_security->responsible_role_id;
        $this->user_id_update = $user_security->user_id;
        $this->type_event_report_id = $user_security->type_event_report_id;
        $this->workgroup_name = $user_security->name;
        $this->parent_Company = $user_security->company_category_id;
        $this->dept = $user_security->dept_by_business_unit_id;
        $this->business_unit = $user_security->busines_unit_id;
    }

    public function render()
    {
        if ($this->event_user_security_id) {
            $this->divider = "Edit Event User Security";
            $this->user_id_update = (empty($this->search_people)) ? $this->user_id_update : $this->user_id_update = null;
        } else {
            $this->divider = "Add Event User Security";
        }

        if ($this->parent_Company) {
            $this->workgroup_name = CompanyCategory::whereId(1)->first()->name_category_company;
        }
        if ($this->business_unit) {
            $this->workgroup_name = BusinesUnit::with(['Department', 'Company'])->whereId($this->business_unit)->first()->Company->name_company;
        }
        if ($this->dept) {
            $depertemen =   DeptByBU::with(['Department', 'BusinesUnit'])->whereId($this->dept)->first();
            $this->workgroup_name = $depertemen->BusinesUnit->Company->name_company . '-' . $depertemen->Department->department_name;
        }
        if ($this->division_id) {
            $this->parent_Company = null;
            $this->business_unit = null;
            $this->dept = null;
            $divisi =   Division::with(['DeptByBU.BusinesUnit.Company', 'DeptByBU.Department', 'Company'])->whereId($this->division_id)->orderBy('dept_by_business_unit_id', 'asc')->first();
            $this->workgroup_name = ($divisi->company_id) ? $divisi->DeptByBU->BusinesUnit->Company->name_company . '-' . $divisi->DeptByBU->Department->department_name . '-' . $divisi->Company->name_company : $divisi->DeptByBU->BusinesUnit->Company->name_company . '-' . $divisi->DeptByBU->Department->department_name;
        }

        return view('livewire.admin.event-user-security.create-and-update', [
            'User' => User::searchId(trim($this->user_id_update))->searchNama(trim($this->search_people))->paginate(100, ['*'], 'User'),
            'ParentCompany' => CompanyCategory::whereId(1)->get(),
            'Division' => Division::with(['DeptByBU.BusinesUnit.Company', 'DeptByBU.Department', 'Company', 'Section'])->searchParent(trim($this->parent_Company))->searchBU(trim($this->business_unit))->searchDept(trim($this->dept))->orderBy('dept_by_business_unit_id', 'asc')->get(),
            'BusinessUnit' => BusinesUnit::with(['Department', 'Company'])->get(),
            'Department' => DeptByBU::with(['Department', 'BusinesUnit'])->orderBy('busines_unit_id', 'asc')->get(),
            'ClassHierarchy' => ClassHierarchy::with(['Company', 'BusinesUnit.Company', 'DeptByBU.BusinesUnit.Company', 'DeptByBU.Department'])->searchParent(trim($this->parent_Company))->searchBU(trim($this->business_unit))->searchDept(trim($this->dept))->get(),
            'ResponsibleRole' => ResponsibleRole::get(),
            'TypeEventReport' => TypeEventReport::get()
        ]);
    }
    public function parentCompany($id)
    {
        $this->parent_Company = $id;
        $this->business_unit = null;
        $this->dept = null;
        $this->division_id = null;
    }
    public function businessUnit($id)
    {
        $this->business_unit = $id;
        $this->parent_Company = null;
        $this->dept = null;
        $this->division_id = null;
    }
    public function department($id)
    {
        $this->dept = $id;
        $this->parent_Company = null;
        $this->business_unit = null;
        $this->division_id = null;
    }
    public function rules()
    {
        if($this->user_id_update)
        {   
            return [
            'responsible_role_id' => ['required'],
            'user_id_update' => ['required'],
            'type_event_report_id' => ['nullable']
            ];
        }
        else
        {
            return [
            'responsible_role_id' => ['required'],
            'user_id' => ['required'],
            'type_event_report_id' => ['nullable']
        ];
        }
    }
    public function messages()
    {
        return [
            'responsible_role_id.required' => 'Responsible Role is required',
            'workgroup_name.required' => 'Workgroup Name is required',
            'user_id.required' => 'People Name is required',
            'type_event_report_id.nullable' => 'Type Event Report is required',
        ];
    }

    public function store()
    {
      
        $this->validate();
        $divisi = ($this->division_id) ?  (int) $this->division_id[0] : null;
        if ( $this->event_user_security_id) {
            EventUserSecurity::updateOrCreate(
                ['id' => $this->event_user_security_id],
                [
                    'name' => $this->workgroup_name,
                    'division_id' => $divisi,
                    'company_category_id' =>  $this->parent_Company,
                    'busines_unit_id' =>  $this->business_unit,
                    'dept_by_business_unit_id' =>  $this->dept,
                    'responsible_role_id' => $this->responsible_role_id,
                    'user_id' => $this->user_id_update,
                    'type_event_report_id' => (!empty($this->type_event_report_id))? $this->type_event_report_id:null,
                ]
            );
        } else {
            foreach ($this->user_id as $key => $value) {
            EventUserSecurity::updateOrCreate(
                ['id' => $this->event_user_security_id],
                [
                    'name' => $this->workgroup_name,
                    'division_id' => $divisi,
                    'company_category_id' =>  $this->parent_Company,
                    'busines_unit_id' =>  $this->business_unit,
                    'dept_by_business_unit_id' =>  $this->dept,
                    'responsible_role_id' => $this->responsible_role_id,
                    'user_id' => $this->user_id[$key],
                    'type_event_report_id' => (!empty($this->type_event_report_id))? $this->type_event_report_id:null,
                ]
            );
        }
        }
        
        if ($this->event_user_security_id) {
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
            $this->reset(['workgroup_name','business_unit','dept','responsible_role_id','user_id','type_event_report_id']);
        }
        $this->dispatch('event_user_security_created');
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
