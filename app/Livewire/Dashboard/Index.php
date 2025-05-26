<?php

namespace App\Livewire\Dashboard;

use DateTime;
use Carbon\Carbon;
use App\Models\Group;
use Livewire\Component;
use App\Models\Division;
use App\Models\Manhours;
use App\Models\DeptGroup;
use App\Models\EventKeyword;
use App\Models\pto_report;
use App\Models\SubConDept;
use Illuminate\Support\Arr;
use App\Models\HazardReport;
use App\Models\IncidentReport;
use App\Models\ManhoursSite;
use Illuminate\Support\Facades\Auth;
use DatePeriod;
use DateInterval;
class Index extends Component
{

    public  $Incident, $Lead_vs_Lag, $responsible_cont_dept, $status_incident, $count_pto, $count_incident, $count_hazard, $key_state, $manhoursltifree,$month,$condition,$action;
    public function mount()
    {

       if (IncidentReport::exists()) {
        $tanggal = IncidentReport::orderBy('date','DESC')->first()->date;

        $date_last = DateTime::createFromFormat('Y-m-d : H:i', $tanggal)->format('d-m-Y');
        $tgl =Carbon::createFromDate($date_last)->subMonths()->subDays(5)->format('Y-m-d');
        $years = Carbon::createFromDate($date_last)->subMonths()->subDays(5)->format('Y');
        $subYear_format = Carbon::createFromDate($date_last)->subYear()->format('Y-m-d');
        $subYear = date('Y-m-d : H:i', strtotime($subYear_format));

        $date1 = Carbon::createFromDate($tgl)->format('d-m-Y');
        $date2 = Carbon::createFromDate($date1)->subMonths(25)->format('d-m-Y');
        $date3 = Carbon::createFromDate($date1)->subMonths(12)->format('d-m-Y');
        $startDate = date('Y-m-d : H:i', strtotime($date2));


        $period = IncidentReport::wherebetween('date', [$startDate, $tanggal])->get();
        $this->condition = EventKeyword::wherebetween('event_date', [$startDate, $tanggal])->where('keyword','LIKE','Condition')->count();
        $this->action = EventKeyword::wherebetween('event_date', [$startDate, $tanggal])->where('keyword','LIKE','Action')->count();
        $current_date = Carbon::now()->subMonths()->subDays(4)->toDateString();
        $manhours_date = DateTime::createFromFormat('Y-m-d', $current_date)->format('Y-m');
        $this->month = DateTime::createFromFormat('Y-m-d', $current_date)->format('F-Y');
        $this->count_incident = IncidentReport::searchMonth(trim(DateTime::createFromFormat('Y-m-d', $current_date)->format('Y-m')))->count();
        $this->count_hazard = HazardReport::searchMonth(trim(DateTime::createFromFormat('Y-m-d', $current_date)->format('Y-m')))->count();
        $this->count_pto = pto_report::searchMonth(trim(DateTime::createFromFormat('Y-m-d', $current_date)->format('Y-m')))->count();
        if (ManhoursSite::SearchDate(trim($manhours_date))->exists()) {
            $freelti = ManhoursSite::SearchDate(trim($manhours_date))->first()->Cummulatives_Manhours_By_LTI;
            $this->manhoursltifree = number_format($freelti, 0, '.', ',');
        }else{
            $this->manhoursltifree =0;
        }
        // Table Keys State
        $group = [];
        $k_s = [];
        // FAI
        $dept_id_fai = IncidentReport::with(['Division.Company', 'Division.DeptByBU.Department'])->search(trim("FAI"))->searchMonth(trim($years))->get()->pluck('Division.DeptByBU.Department.id');
        $comp_id_fai = IncidentReport::with(['Division.Company', 'Division.DeptByBU.Department'])->search(trim("FAI"))->searchMonth(trim($years))->get()->pluck('Division.Company.id');
        $contractor_fai = SubConDept::whereIn('company_id', $comp_id_fai)->get()->pluck('department_id');
        $departement_fai =  Arr::collapse([$dept_id_fai, $contractor_fai]);

        foreach ($departement_fai as $key) {
            if (DeptGroup::where('department_id', $key)->exists()) {
                # code...
                $group['group_fai'][] = DeptGroup::where('department_id', $key)->first()->group_id;
            }
        }
        // LTI
        $dept_id_lti = IncidentReport::with(['Division.Company', 'Division.DeptByBU.Department'])->search(trim("LTI"))->searchMonth(trim($years))->get()->pluck('Division.DeptByBU.Department.id');
        $comp_id_lti = IncidentReport::with(['Division.Company', 'Division.DeptByBU.Department'])->search(trim("LTI"))->searchMonth(trim($years))->get()->pluck('Division.Company.id');
        $contractor_lti = SubConDept::whereIn('company_id', $comp_id_lti)->get()->pluck('department_id');
        $departement_lti =  Arr::collapse([$dept_id_lti, $contractor_lti]);

        foreach ($departement_lti as $key) {
            if (DeptGroup::where('department_id', $key)->exists()) {

                $group['group_lti'][] = DeptGroup::where('department_id', $key)->first()->group_id;
            }
        }
        // MTI
        $dept_id_mti = IncidentReport::with(['Division.Company', 'Division.DeptByBU.Department'])->search(trim("MTI"))->searchMonth(trim($years))->get()->pluck('Division.DeptByBU.Department.id');
        $comp_id_mti = IncidentReport::with(['Division.Company', 'Division.DeptByBU.Department'])->search(trim("MTI"))->searchMonth(trim($years))->get()->pluck('Division.Company.id');
        $contractor_mti = SubConDept::whereIn('company_id', $comp_id_mti)->get()->pluck('department_id');
        $departement_mti =  Arr::collapse([$dept_id_mti, $contractor_mti]);

        foreach ($departement_mti as $key) {
            if (DeptGroup::where('department_id', $key)->exists()) {
                # code...
                $group['group_mti'][] = DeptGroup::where('department_id', $key)->first()->group_id;
            }
        }
        // RDI
        $dept_id_rdi = IncidentReport::with(['Division.Company', 'Division.DeptByBU.Department'])->search(trim("RDI"))->searchMonth(trim($years))->get()->pluck('Division.DeptByBU.Department.id');
        $comp_id_rdi = IncidentReport::with(['Division.Company', 'Division.DeptByBU.Department'])->search(trim("RDI"))->searchMonth(trim($years))->get()->pluck('Division.Company.id');
        $contractor_rdi = SubConDept::whereIn('company_id', $comp_id_rdi)->get()->pluck('department_id');
        $departement_rdi =  Arr::collapse([$dept_id_rdi, $contractor_rdi]);

        foreach ($departement_rdi as $key) {
            if (DeptGroup::where('department_id', $key)->exists()) {
                # code...
                $group['group_rdi'][] = DeptGroup::where('department_id', $key)->first()->group_id;
            }
        }
        // Group in Incident
        $dept_id_incident = IncidentReport::with(['Division.Company', 'Division.DeptByBU.Department'])->where('potential_lti','LIKE','Yes')->searchMonth(trim(DateTime::createFromFormat('Y-m-d : H:i', $tanggal)->format('Y')))->get()->pluck('Division.DeptByBU.Department.id');
        $comp_id_incident = IncidentReport::with(['Division.Company', 'Division.DeptByBU.Department'])->where('potential_lti','LIKE','Yes')->searchMonth(trim(DateTime::createFromFormat('Y-m-d : H:i', $tanggal)->format('Y')))->get()->pluck('Division.Company.id');
        $contractor_incident = SubConDept::whereIn('company_id', $comp_id_incident)->get()->pluck('department_id');
        $departement_incident =  Arr::collapse([$dept_id_incident, $contractor_incident]);

        foreach ($departement_incident as $key) {
            if (DeptGroup::where('department_id', $key)->exists()) {
                # code...
                $group['departement_incident'][] = DeptGroup::where('department_id', $key)->first()->group_id;
            }
        }
        // Group in Incident Previouse
        $dept_id_incident_previouse = IncidentReport::with(['Division.Company', 'Division.DeptByBU.Department'])->where('potential_lti','LIKE','Yes')->searchMonth(trim(DateTime::createFromFormat('Y-m-d : H:i', $subYear)->format('Y')))->get()->pluck('Division.DeptByBU.Department.id');
        $comp_id_incident_previouse = IncidentReport::with(['Division.Company', 'Division.DeptByBU.Department'])->where('potential_lti','LIKE','Yes')->searchMonth(trim(DateTime::createFromFormat('Y-m-d : H:i', $subYear)->format('Y')))->get()->pluck('Division.Company.id');
        $contractor_incident_previouse = SubConDept::whereIn('company_id', $comp_id_incident_previouse)->get()->pluck('department_id');
        $departement_incident_previouse =  Arr::collapse([$dept_id_incident_previouse, $contractor_incident_previouse]);

        foreach ($departement_incident_previouse as $key) {
            if (DeptGroup::where('department_id', $key)->exists()) {
                # code...
                $group['departement_incident_previouse'][] = DeptGroup::where('department_id', $key)->first()->group_id;
            }
        }
        $group_fai = ($departement_fai) ? $group['group_fai'] : '';
        $group_lti = ($departement_lti) ? $group['group_lti'] : '';
        $group_mti = ($departement_mti) ? $group['group_mti'] : '';
        $group_rdi = ($departement_rdi) ? $group['group_rdi'] : '';
        $departement_incident = ($departement_incident) ? $group['departement_incident'] : '';
        $departement_incident_previouse = ($departement_incident_previouse) ? $group['departement_incident_previouse'] : '';

        $Group = Group::get();
        foreach ($Group as $groups) {
            $k_s['group'][] = $name = $groups->group_name;
            if ($departement_incident_previouse) {
                if (in_array($groups->id, $departement_incident_previouse)) {
                    $k_s['departement_incident_previouse'][] = array_count_values($departement_incident_previouse)[$groups->id];
                } else {
                    $k_s['departement_incident_previouse'][] = 0;
                }
            } else {
                $k_s['departement_incident_previouse'][] = 0;
            }
            if ($departement_incident) {
                if (in_array($groups->id, $departement_incident)) {
                    $k_s['departement_incident'][] = array_count_values($departement_incident)[$groups->id];
                } else {
                    $k_s['departement_incident'][] = 0;
                }
            } else {
                $k_s['departement_incident'][] = 0;
            }
            if ($departement_fai) {
                if (in_array($groups->id, $group_fai)) {
                    $k_s['fai'][] = array_count_values($group_fai)[$groups->id];
                } else {
                    $k_s['fai'][] = 0;
                }
            } else {
                $k_s['fai'][] = 0;
            }
            if ($departement_lti) {
                if (in_array($groups->id, $group_lti)) {
                    $k_s['lti'][] = $lti_count =  array_count_values($group_lti)[$groups->id];
                    $startDate_Manhours = date('Y-m-d', strtotime($date3));
                    $manhours_lti = Manhours::searchDeptGroup(trim($groups->group_name))->wherebetween('date', [date('Y-m-d', strtotime($startDate_Manhours)), DateTime::createFromFormat('Y-m-d : H:i', $tanggal)->format('Y-m-d')])->sum('manhours');
                    $k_s['lti_fr'][] = number_format($lti_count / number_format($manhours_lti, 0, '.', '') * 1000000, 2, '.', '');
                } else {
                    $k_s['lti'][] = 0;
                    $k_s['lti_fr'][] = 0.00;
                }
            } else {
                $k_s['lti'][] = 0;
                $k_s['lti_fr'][] = 0.00;
            }
            if ($departement_mti) {
                if (in_array($groups->id, $group_mti)) {

                    $k_s['mti'][] = array_count_values($group_mti)[$groups->id];

                } else {
                    $k_s['mti'][] = 0;
                }
            } else {
                $k_s['mti'][] = 0;
            }
            if ($departement_rdi) {
                if (in_array($groups->id, $group_rdi)) {
                    $k_s['rdi'][] = array_count_values($group_rdi)[$groups->id];
                } else {
                    $k_s['rdi'][] = 0;
                }
            } else {
                $k_s['rdi'][] = 0;
            }
        }

        $startDate24Month = date('Y-m-d : H:i', strtotime($date2));
        $startDate24Month =  DateTime::createFromFormat('Y-m-d : H:i',$startDate24Month)->format('Y-m');
        $startDate12Month = date('Y-m-d : H:i', strtotime($date3));
        $startDate12Month =  DateTime::createFromFormat('Y-m-d : H:i',$startDate12Month)->format('Y-m');
        $date_now= Carbon::now()->format('Y-m-d');
        $endDate = date('Y-m-d : H:i', strtotime($date_now ));
        $endDateMonth =  DateTime::createFromFormat('Y-m-d : H:i',$endDate)->format('Y-m');
        $start12Month    = new DateTime($startDate12Month);
        $start24Month    = new DateTime($startDate24Month);
        $end      = new DateTime($endDateMonth);
        $interval = DateInterval::createFromDateString('1 month');
        $range24Month   = new DatePeriod($start24Month, $interval, $end);
        $range12Month   = new DatePeriod($start12Month, $interval, $end);
        $this->key_state = json_encode($k_s);
        $data = [];
        foreach ($range24Month as $dt) {
            $data['months'][]  = $dt->format("M-Y");
            $data['LTI'][]  = IncidentReport::searchMonth(trim($dt->format("Y-m")))->search('LTI')->count();
            $data['FAI'][]  = IncidentReport::searchMonth(trim($dt->format("Y-m")))->search('FAI')->count();
            $data['MTI'][]  = IncidentReport::searchMonth(trim($dt->format("Y-m")))->search('MTI')->count();
            $data['RDI'][]  = IncidentReport::searchMonth(trim($dt->format("Y-m")))->search('RDI')->count();
            $startDate  = Carbon::createFromDate($dt->format("Y-m"))->subMonths(12)->format('d-m-Y');
            $manhours = Manhours::wherebetween('date', [date('Y-m-d', strtotime($startDate)), $dt->format("Y-m-d")])->sum('manhours');
            $lti = IncidentReport::wherebetween('date', [date('Y-m-d : H:i', strtotime($startDate)), $tanggal])->search('LTI')->count();
            $data['LTIFR'][]  = number_format(($lti / $manhours) * 1000000, 2);
            $data['LTIFR_Target'][]  = 0.15;
        }


        $this->Incident = json_encode($data);
        $startDate2 = date('Y-m-d : H:i', strtotime($date3));
        $period12Month = IncidentReport::wherebetween('date', [$startDate2, $tanggal])->get();

        $indicator = [];
        $status = [];
        foreach ($range12Month as $dt) {
            $indicator['date'][] = $dt->format("M-Y");
            $indicator['incident'][] = IncidentReport::searchMonth(trim($dt->format("Y-m")))->count();
            $indicator['total_lead'][] = HazardReport::searchMonth(trim($dt->format("Y-m")))->count();
            $status['date'][] =  $dt->format("M-Y");
            $status['open'][] = IncidentReport::searchMonth(trim($dt->format("Y-m")))->statusOpen(trim('Closed'))->count();
            $status['closed'][] = IncidentReport::searchMonth(trim($dt->format("Y-m")))->searchStatus(trim('Closed'))->count();
        }
        $this->Lead_vs_Lag = json_encode($indicator);
        $this->status_incident = json_encode($status);

        $Responsible_byDeptORCont = IncidentReport::with(['Division.Company', 'Division.DeptByBU.Department'])->searchMonth(trim($years))->pluck('division_id');
        $division = Division::whereIn('id', $Responsible_byDeptORCont)->groupby('dept_by_business_unit_id')->get();
        $reesponsible = [];
        foreach ($division as $value) {
            $reesponsible['name'][] = $name = ($value->company_id) ? $value->Company->name_company : $value->DeptByBU->Department->department_name;

            $reesponsible['open'][] = ($value->company_id) ? IncidentReport::searchDivisionCompany(trim($name))->statusOpen(trim('Closed'))->count() :  IncidentReport::searchDivision(trim($name))->statusOpen(trim('Closed'))->count();
            $reesponsible['closed'][] = IncidentReport::searchDivision(trim($name))->searchStatus(trim('Closed'))->count();
        }
        $reesponsible['years'][] = $years;
        $this->responsible_cont_dept = json_encode($reesponsible);
       }
    }
    public function render()
    {
        return view('livewire.dashboard.index')->extends('base.index', ['header' => 'Dashboard', 'title' => 'Dashboard'])->section('content');
    }
}
