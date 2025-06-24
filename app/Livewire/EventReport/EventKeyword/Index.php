<?php

namespace App\Livewire\EventReport\EventKeyword;

use Livewire\Component;
use Illuminate\Support\Arr;
use Livewire\Attributes\On;
use App\Models\EventKeyword;
use App\Models\HazardReport;
use App\Models\KeywordMaintenance;

class Index extends Component
{
    public $hazard_id, $reference, $parent_id = [],$current_step, $report_type, $event_keyword_id, $Event_Keyword = [], $event_date, $key_id, $show_checked;
    public function mount(HazardReport $data)
    {
        $this->hazard_id = $data->id;
        $this->reference = $data->reference;
        $this->event_date = $data->date;
        $this->report_type = ($data->event_type_id != null) ? $data->eventType->type_eventreport_name : "";
        $this->parent_id = EventKeyword::where('reference', $this->reference)->pluck('keyword')->toArray();

        $this->event_keyword_id = EventKeyword::where('reference', $this->reference)->pluck('keyword')->toArray();
    }
     #[On('panel_hazard')]
    public function updatePanel()
    {
        $HazardReport = HazardReport::whereId($this->hazard_id)->first();
        $this->current_step = $HazardReport->WorkflowDetails->name;
    }
    public function render()
    {
        $this->Event_Keyword = EventKeyword::where('reference', $this->reference)->pluck('keyword')->toArray();
        $key_pluck = [];
        foreach ($this->Event_Keyword as $key) {
            $key_pluck[] = $key1 = KeywordMaintenance::where('name', $key)->first()->parent_id;
            $key_pluck[] = $key2 = KeywordMaintenance::whereId($key1)->first()->parent_id;
            $key_pluck[] = $key3 = (KeywordMaintenance::whereId($key2)->exists()) ? KeywordMaintenance::whereId($key2)->first()->parent_id : '';
            $key_pluck[] = $key4 = (KeywordMaintenance::whereId($key3)->exists()) ? KeywordMaintenance::whereId($key3)->first()->parent_id : '';
        }
        $this->key_id = $key_pluck;

        $id_key = [];
        if ($this->show_checked == 1) {
            $keyword = KeywordMaintenance::whereIn('name', $this->Event_Keyword)->with('children')->get();
            foreach ($keyword as $key) {
                $id_key[] = $key->id;
            }
            $this->parent_id = $id_key;
        } else {
            $keyword = KeywordMaintenance::whereNull('parent_id')->with('children')->get();
            $this->parent_id = EventKeyword::where('reference', $this->reference)->pluck('keyword')->toArray();
        }
        return view('livewire.event-report.event-keyword.index', [
            'Keyword' => $keyword,

        ]);
    }
    public function rules()
    {
        return [
            'parent_id' => ['nullable'],

        ];
    }
    public function messages()
    {
        return [
            'parent_id.required' => 'Event Keyword is required',

        ];
    }
    public function store_keyword()
    {

        $this->validate();
        foreach ($this->parent_id as $key => $value) {

            EventKeyword::updateOrCreate(
                ['reference' => $this->reference, 'keyword' => $this->parent_id[$key]],
                [
                    'report_type' => $this->report_type,
                    'keyword' => $this->parent_id[$key],
                    'reference' =>  $this->reference,
                    'event_date' =>  $this->event_date,
                ]
            );
        }
        EventKeyword::where('reference', $this->reference)->whereNotIn('keyword', $this->parent_id)->delete();
    }
}
