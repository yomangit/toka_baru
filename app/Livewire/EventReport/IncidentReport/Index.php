<?php

namespace App\Livewire\EventReport\IncidentReport;

use Livewire\Component;
use App\Models\StatusEvent;
use Livewire\Attributes\On;
use App\Models\EventKeyword;
use App\Models\Eventsubtype;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Models\route_request;
use App\Models\ActionIncident;
use App\Models\choseEventType;
use App\Models\IncidentReport;
use App\Models\TypeEventReport;
use Illuminate\Support\Facades\Auth;
use App\Models\IncidentDocumentation;
use Illuminate\Support\Facades\Request;

class Index extends Component
{
    use WithPagination;
    #[Url]
    public $rangeDate='', $search_workgroup = '', $search_eventType = '',$search_eventSubType='', $search_status = '',$searching='',$workflow_template_id,$show=false,$in_tray,$user_id;
    public $EventSubType = [];
    public $startDate,$endDate;
    public $tglMulai,$tglAkhir;


    public function render()
    {
         if ($this->in_tray) {
            $this->user_id = Auth::user()->id;
        } else {
            $this->user_id = '';
        }

        if ($this->rangeDate) {
            $incident = IncidentReport::with([
                'WorkflowDetails',
                'subEventType',
                'eventType',
            ])->searchTray(trim($this->user_id))->searchStatus(trim($this->search_status))->searchEventType(trim($this->search_eventType))->searchEventSubType(trim($this->search_eventSubType))->whereBetween('date',array([$this->tglMulai, $this->tglAkhir ]))->search(trim($this->searching))->paginate(30);


        }else{
            $incident = IncidentReport::with([
                'WorkflowDetails',
                'subEventType',
                'eventType',
            ])->searchTray(trim($this->user_id))->searchStatus(trim($this->search_status))->searchEventType(trim($this->search_eventType))->searchEventSubType(trim($this->search_eventSubType))->search(trim($this->searching))->paginate(30);
        }

        if (Auth::user()->role_user_permit_id == 1) {
            $this->show=true;
        }
        if (route_request::where('route_name','LIKE',Request::getPathInfo())->exists()) {
            $this->workflow_template_id = route_request::where('route_name','LIKE',Request::getPathInfo())->first()->workflow_template_id;

           }else{
            $this->workflow_template_id ="";
           }
            if (choseEventType::where('route_name','LIKE','%'. '/eventReport/incidentReport'.'%')->exists()) {
            $eventType = choseEventType::where('route_name','LIKE','%'. '/eventReport/incidentReport'.'%')->pluck('event_type_id');

            $Event_type = TypeEventReport::whereIn('id', $eventType)->get();

           }else{
            $Event_type =[];
           }
        $this->EventSubType = (isset($this->search_eventType)) ?  $this->EventSubType = Eventsubtype::where('event_type_id', $this->search_eventType)->get() : [];
        return view('livewire.event-report.incident-report.index', [
            'IncidentReport' => $incident,
            'IncidentAction' => ActionIncident::get(),
            'Status' => StatusEvent::get(),
            'EventType' => $Event_type,
        ])->extends('base.index', ['header' => 'Incident Report', 'title' => 'Incident Report'])->section('content');
    }

    public function delete($id)
    {
        $incidentReport = IncidentReport::whereId($id);
        $files = IncidentDocumentation::where('incident_id', $id);
        EventKeyword::where('reference',$this->reference)->delete();
        if (isset( $files->first()->name_doc)) {
            unlink(storage_path('app/public/documents/incident/' .   $files->first()->name_doc));
        }
        $incidentReport->delete();
        $this->dispatch(
            'alert',
            [
                'text' => "The Event report was deleted!!",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #ff3333, #ff6666)",
            ]
        );
    }
}
