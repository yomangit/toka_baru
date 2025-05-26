<?php

namespace App\Livewire\EventReport\EventPartisipan;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\HazardReport;
use App\Models\TypeInvolvement;
use App\Models\EventParticipants;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{

    public $people_name='';
    public $user_id,$type_involvement_id,$event_type_id,$sub_event_type_id,$reference;
    public $Partisipan,$data_id,$current_step,$update_id;
    public $divider='';


    public function mount(HazardReport $hazard, EventParticipants $participan) {

        $this->data_id = $hazard->id;
        $this->event_type_id = $hazard->event_type_id;
        $this->sub_event_type_id = $hazard->sub_event_type_id;
        $this->reference = $hazard->reference;
        $this->update_id = $participan->id;
        if ($this->update_id) {
            $this->people_name = $participan->User->lookup_name;
            $this->user_id = $participan->user_id;
            $this->type_involvement_id = $participan->type_involvement_id;
        }
    }
    public function rules()
    {
        return [
            'people_name' => ['required'],
            'type_involvement_id' => ['required']
        ];
    }
    public function messages()
    {
        return [
            'people_name.required' => 'employee involved fild is required',
            'type_involvement_id.required' => 'type of involvement fild is required',
        ];
    }
    public function render()
    {
        if ($this->update_id) {
            $this->divider="Update Participant";
        } else {
            $this->divider="Add Participant";
        }
        
        $this->updatePanel();
        return view('livewire.event-report.event-partisipan.create-and-update',[
            'User' =>User::with('company')->searchNama(trim($this->people_name))->limit(1000)->get(),
            'TypeInvolvement' =>TypeInvolvement::get()
        ]);
    }
    #[On('panel_hazard')]
    public function updatePanel()
    {
        $HazardReport = HazardReport::whereId($this->data_id)->first();
        $this->current_step = $HazardReport->WorkflowDetails->name;
    }
    public function people_selected($id,$name){
        $this->user_id = $id;
        $this->people_name = $name;
    }
    public function store()
    {
        $this->validate();
        EventParticipants::updateOrCreate(
            ['id' => $this->update_id],
            [
                'user_id' => $this->user_id,
                'type_involvement_id' => $this->type_involvement_id,
                'reference' =>  $this->reference,
                'eventsubtype_id' => $this->sub_event_type_id,
                'type_event_report_id' => $this->event_type_id,
            ]
        );
        if ($this->update_id) {
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
            $this->reset(['people_name','type_involvement_id','user_id']);
        }
        $this->dispatch('eventParticipan_created');
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
