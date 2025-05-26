<?php

namespace App\Livewire\Admin\EventUserSecurity;

use App\Models\User;
use Livewire\Component;
use App\Models\DeptByBU;
use App\Models\Division;
use App\Models\Workgroup;
use App\Models\BusinesUnit;
use Livewire\Attributes\Url;
use App\Models\CompanyCategory;
use App\Models\ResponsibleRole;
use App\Models\TypeEventReport;
use App\Models\EventUserSecurity;

class Index extends Component
{
    protected $listeners = ['event_user_security_created' => 'render'];
    #[Url]
    public $search_people = '';
    public $modal="modal";
    public $responsible_role_id, $workgroup_name, $user_id_update, $workgroup_id, $type_event_report_id, $data_id,$division_id,$parent_Company, $business_unit, $dept;
    public function render()
    {
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
            $divisi = Division::with(['DeptByBU.BusinesUnit.Company', 'DeptByBU.Department', 'Company'])->whereId($this->division_id)->first();
            $this->workgroup_name = ($divisi->company_id) ? $divisi->DeptByBU->BusinesUnit->Company->name_company . '-' . $divisi->DeptByBU->Department->department_name . '-' . $divisi->Company->name_company  : $divisi->DeptByBU->BusinesUnit->Company->name_company . '-' . $divisi->DeptByBU->Department->department_name;
        }
        return view('livewire.admin.event-user-security.index', [
            'UserSecurity' => EventUserSecurity::with([
                'Division.DeptByBU.BusinesUnit.Company',
                'Division.DeptByBU.Department',
                'Division.Company',
                'DeptByBU.BusinesUnit.Company',
                'DeptByBU.Department',
                'BusinesUnit.Company',
                'ResponsibleRole',
                'Company',
                'User',
                'EventType'
            ])->paginate(20),
            'User' => User::searchId(trim($this->user_id_update))->paginate(100, ['*'], 'User'),
            'ParentCompany' => CompanyCategory::whereId(1)->get(),
            'BusinessUnit' => BusinesUnit::with(['Department', 'Company'])->get(),
            'Department' => DeptByBU::with(['Department', 'BusinesUnit'])->orderBy('busines_unit_id', 'asc')->get(),
            'Division' => Division::with(['DeptByBU.BusinesUnit.Company', 'DeptByBU.Department', 'Company'])->searchParent(trim($this->parent_Company))->searchBU(trim($this->business_unit))->searchDept(trim($this->dept))->orderBy('dept_by_business_unit_id', 'asc')->get(),
            'ResponsibleRole' => ResponsibleRole::get(),
            'TypeEventReport' => TypeEventReport::get()
        ])->extends('base.index', ['header' => 'Event User Security', 'title' => 'Event User Security'])->section('content');
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
    public function updateData($id)
    {
        $this->modal="modal modal-open";
        $this->data_id = $id;
        // $this->dispatch('event_user_security_updated', $id);
        $eventUserSecurity = EventUserSecurity::where('id', $this->data_id)->first();
        $this->responsible_role_id = $eventUserSecurity->responsible_role_id;
        $this->user_id_update = $eventUserSecurity->user_id;
        $this->parent_Company = $eventUserSecurity->company_categorie_id;
        $this->dept = $eventUserSecurity->dept_by_business_unit_id;
        $this->business_unit = $eventUserSecurity->busines_unit_id;
        $this->division_id = $eventUserSecurity->division_id;
        $this->type_event_report_id = $eventUserSecurity->type_event_report_id;
    }
    public function closeModal(){
        $this->modal = "modal";
    }
    public function store()
    {
        $this->validate([
            'responsible_role_id' => ['required'],
            'workgroup_name' => ['required'],
            'user_id_update' => ['required'],
            'type_event_report_id' => ['required']
        ]);
        EventUserSecurity::where('id', $this->data_id)->update([
            'workgroup_id' => $this->workgroup_id,
            'responsible_role_id' => $this->responsible_role_id,
            'user_id' => $this->user_id_update,
            'type_event_report_id' => $this->type_event_report_id,
        ]);
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
    }
    public function delete($id)
    {
        $deleteFile = EventUserSecurity::whereId($id);
        $deleteFile->delete();
        $this->dispatch(
            'alert',
            [
                'text' => "Deleted Data Successfully!!",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #f97316, #ef4444)",
            ]
        );
    }
}
