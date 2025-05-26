<?php

namespace App\Livewire\ManhoursSite;


use DateTime;
use DatePeriod;
use DateInterval;
use Livewire\Component;
use App\Models\Manhours;
use App\Models\ManhoursSite;
use Livewire\WithFileUploads;
use App\Models\IncidentReport;
use App\Imports\ManhoursSiteImport;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithFileUploads;
    public $manhoursSite_id, $modal, $search = '',$Loop=[];
    public $date, $files, $company_employee, $company_manhours, $Company_Cummulatives, $Contractor_Workhours, $Contractor_Employee, $Contractor_Cummulatives, $Total_Employee, $Total_Workhours, $Total_Cummulatives, $Cummulatives_Manhours_By_LTI, $Manhours_Lost, $LTI, $LTI_Date;
    public function modalMS(ManhoursSite $id)
    {
        $this->modal = "modal-open";
        $this->manhoursSite_id = $id->id;

        if ($this->manhoursSite_id) {
            $this->date = date('M-Y', strtotime($id->date));
        }
    }

    public function render()
    {
        $this->getManhoursSite();
        $this->loopMonth();
        return view('livewire.manhours-site.index', [
            'ManhoursSite' => ManhoursSite::orderBy('date', 'desc')->get()
        ])->extends('base.index', ['header' => 'Manhours Site', 'title' => 'Manhours Site'])->section('content');
    }
    public function loopMonth(){
        $tanggalAwal = ManhoursSite::orderBy('date','DESC')->first()->date;
        $tanggalAwal = DateTime::createFromFormat('Y/m/d',date('Y/m/d', strtotime($tanggalAwal)))->format('Y-m');
        $tglAwal = DateTime::createFromFormat('Y/m/d',date('Y/m/d', strtotime($tanggalAwal)))->format('Y-m');
        $Awal = date('Y/m/d', strtotime($tanggalAwal . " +1 month"));
        $tanggalAkhir = Manhours::orderBy('date','DESC')->first()->date;
        $tanggalAkhir = DateTime::createFromFormat('Y/m/d',date('Y/m/d', strtotime($tanggalAkhir)))->format('Y-m');
        $interval = DateInterval::createFromDateString('1 month');
        $tanggalAwal    = new DateTime($tanggalAwal);
        $tanggalAkhir    = new DateTime($tanggalAkhir);
        $range   = new DatePeriod($tanggalAwal, $interval, $tanggalAkhir);
        
        $prev_cummulatives = ManhoursSite::orderBy('date','DESC')->latest()->first();
        $companyCum = $prev_cummulatives->Company_Cummulatives;
        $contCum = $prev_cummulatives->Contractor_Cummulatives;
        $totalCum = $prev_cummulatives->Total_Cummulatives;
        foreach ($range as $dt) {
            $bulanLalu = date('M-Y', strtotime($dt->format("M-Y") . " -1 month"));
            $bulanDepan = date('M-Y', strtotime($dt->format("M-Y") . " +1 month"));
            $bulanBerjalan = $dt->format("M-Y");
            $manhours_site['bulanBerjalan'][]  =$bulanBerjalan;
            $Manhours = Manhours::searchDate(trim($dt->format("Y/m")));
           
            $manhours_site['company_employee'][]  = $Manhours->where('company_category', 'LIKE', '%' . "ARCHI" . '%')->sum('manpower');
            $manhours_site['company_manhours'][]  = $company_manhours = (int) $Manhours->where('company_category', 'LIKE', '%' . "ARCHI" . '%')->sum('manhours');
        }
        
         $ManhoursCount = Manhours::whereBetween('date', array([$Awal, $tanggalAkhir]))->get();
         foreach($ManhoursCount as $item)
         {
             $companyCum+=$item->manhours;
              $manhours_site['Company_Cummulatives'][]  =  $companyCum ;
         }
            $this->Loop = json_encode($manhours_site);
    }
    public function getManhoursSite()
    {
        
        if ($this->date) {
            $date = date('Y/m', strtotime($this->date));
            $previouse_date = date('Y-m', strtotime($this->date . " -1 month"));
            $prev_cummulatives = ManhoursSite::searchDate(trim($previouse_date))->first();
            $companyCum = $prev_cummulatives->Company_Cummulatives;
            $contCum = $prev_cummulatives->Contractor_Cummulatives;
            $totalCum = $prev_cummulatives->Total_Cummulatives;
            $cumbyLTI = $prev_cummulatives->Cummulatives_Manhours_By_LTI;
            $Manhours = Manhours::searchDate(trim($date));
            $ManhoursCont = Manhours::searchDate(trim($date));
            $ManhoursTotal = Manhours::searchDate(trim($date));

            $this->company_employee = $Manhours->where('company_category', 'LIKE', '%' . "ARCHI" . '%')->sum('manpower');
            $this->company_manhours = (int) $Manhours->where('company_category', 'LIKE', '%' . "ARCHI" . '%')->sum('manhours');
            
            $this->Company_Cummulatives = $companyCum + $this->company_manhours;
            $this->Contractor_Employee = $ManhoursCont->where('company_category', 'LIKE', '%' . "Contractor" . '%')->sum('manpower');
            $this->Contractor_Workhours = (int) $ManhoursCont->where('company_category', 'LIKE', '%' . "Contractor" . '%')->sum('manhours');
            $this->Contractor_Cummulatives = $contCum + $this->Contractor_Workhours;
            $this->Total_Employee = $ManhoursTotal->sum('manpower');
            $this->Total_Workhours = (int) $ManhoursTotal->sum('manhours');

            $this->Total_Cummulatives = $totalCum + $this->Total_Workhours;
            if (IncidentReport::searchMonth(trim($date))->search(trim('LTI'))->exists()) {
                $this->LTI = IncidentReport::searchMonth(trim($date))->search(trim('LTI'))->count('sub_event_type_id');
                $lti_date = IncidentReport::searchMonth(trim($date))->search(trim('LTI'))->first()->date;

                $this->LTI_Date =  DateTime::createFromFormat('Y/m/d : H:i', $lti_date)->format('d-m-Y');
                $year = date('Y', strtotime($this->LTI_Date));
                $month = date('m', strtotime($this->LTI_Date));
                $day = date('d', strtotime($this->LTI_Date));
                $totalDaysofMonths = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $this->Manhours_Lost = round(round($day / $totalDaysofMonths, 2) * $this->Total_Workhours, 0);
                $this->Cummulatives_Manhours_By_LTI = $this->Total_Workhours - $this->Manhours_Lost;
            } else {
                $this->LTI = null;
                $this->LTI_Date = null;
                $this->Manhours_Lost = null;
                $this->Cummulatives_Manhours_By_LTI = $this->Total_Workhours + $cumbyLTI;
            }
        }
    }
    public function store()
    {
        $this->validate(['date' => 'required']);
        ManhoursSite::updateOrCreate(
            ['id' => $this->manhoursSite_id],
            [
                'date' => date('Y-m-d', strtotime($this->date)),
                'Company_Employee' => $this->company_employee,
                'Company_Workhours' => $this->company_manhours,
                'Company_Cummulatives' => $this->Company_Cummulatives,
                'Contractor_Employee' => $this->Contractor_Employee,
                'Contractor_Workhours' => $this->Contractor_Workhours,
                'Contractor_Cummulatives' => $this->Contractor_Cummulatives,
                'Total_Employee' => $this->Total_Employee,
                'Total_Workhours' => $this->Total_Workhours,
                'Total_Cummulatives' => $this->Total_Cummulatives,
                'Cummulatives_Manhours_By_LTI' => $this->Cummulatives_Manhours_By_LTI,
                'Manhours_Lost' => $this->Manhours_Lost,
                'LTI' => $this->LTI,
                'LTI_Date' => $this->LTI_Date
            ]
        );

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
        if ($this->manhoursSite_id) {
            $this->closeModal();
        }
    }
    public function uploadManhours()
    {
        set_time_limit(300);
        $this->validate(['files' => 'required']);

        Excel::import(new ManhoursSiteImport, $this->files);
        $this->dispatch(
            'alert',
            [
                'text' => "Data Upload Successfully!!",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #00b09b, #96c93d)",
            ]
        );
    }
    public function closeModal()
    {
        $this->reset('modal');
    }
    public function delete($id)
    {
        $deleteFile = ManhoursSite::whereId($id);
        $deleteFile->delete();
        $this->dispatch(
            'alert',
            [
                'text' => "data successfully deleted!!",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #ff3333, #ff6666)",
            ]
        );
    }
}
