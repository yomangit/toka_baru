<?php

namespace App\Livewire\EventReport\PtoReport;

use App\Models\DocumentationOfPto;
use App\Models\ObserverAction;
use App\Models\ObserverTeam;
use Livewire\Component;
use App\Models\pto_report;
use Illuminate\Support\Str;
use Cjmellor\Approval\Models\Approval;
use Illuminate\Support\Facades\Request;
use App\Models\route_request;
class Index extends Component
{

    public $reference, $rangeDate, $searching,$show=false,$workflow_template_id,$getPathInfo;
    public $tglMulai, $tglAkhir;
    public function render()
    {
        Approval::whereDate('created_at', '<=', now()->subDays(30))->delete();
        $pto = pto_report::exists();
        $referencePTO = "OHS-PTO-";
        if (!$pto) {
            $reference = 1;
            $references =  str_pad($reference, 4, "0", STR_PAD_LEFT);
            $this->reference = $referencePTO . $references;
        } else {
            $pto = pto_report::latest()->first();
            $reference = $pto->id + 1;
            $references =  str_pad($reference, 4, "0", STR_PAD_LEFT);
            $this->reference = $referencePTO . $references;
        }
        if (route_request::where('route_name','LIKE',Request::getPathInfo())->exists()) {
        $this->workflow_template_id = route_request::where('route_name','LIKE',Request::getPathInfo())->first()->workflow_template_id;
       }else{
        $this->workflow_template_id ="";
       }

        if (auth()->user()->role_user_permit_id == 1) {
            $this->show=true;
        }
         if ($this->rangeDate) {
            $pto = pto_report::with(['WorkflowDetails'])->whereBetween('date', [array($this->tglMulai), array($this->tglAkhir)])->paginate(10);
        }else{
             $pto = pto_report::with(['WorkflowDetails'])->paginate(10);
        }
        return view('livewire.event-report.pto-report.index', [
            'PTO_Report' => $pto,
            'PTO_Action' => ObserverAction::get(),
        ])->extends('base.index', ['header' => 'PTO', 'title' => 'PTO'])->section('content');
    }
    public function delete($id)
    {
        $deleteFile = pto_report::whereId($id);
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
        $reference = pto_report::whereId($id)->first()->reference;
        ObserverAction::where('reference',$reference)->delete();
        ObserverTeam::where('reference',$reference)->delete();
        DocumentationOfPto::where('reference',$reference)->delete();
        $deleteFile->delete();
    }
}
