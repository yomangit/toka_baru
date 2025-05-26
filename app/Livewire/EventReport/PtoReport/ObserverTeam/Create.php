<?php

namespace App\Livewire\EventReport\PtoReport\ObserverTeam;

use App\Models\User;
use Livewire\Component;
use Cjmellor\Approval\Models\Approval;
use Livewire\Attributes\On;
use App\Models\ObserverTeam;
use App\Models\pto_report;

class Create extends Component
{
    public $divider,$pto_id;
    public $reference, $modal, $name_people, $id_card, $job_title, $observer_team, $name_id;

    public function mount($reference, pto_report $id)
    {
        $this->reference = $reference;
        $this->pto_id = $id->id;
    }
    #[On('openModalPtoTeam')]
    public function openModalPtoTeam(ObserverTeam $ptoTeam)
    {

        $this->modal = "modal-open";
        $this->observer_team = $ptoTeam->id;
        if ($this->observer_team) {
            $this->name_people = $ptoTeam->name;
            $this->id_card = $ptoTeam->id_card;
            $this->job_title = $ptoTeam->job_title;
        }
    }
    public function rules()
    {
        return [
            'name_people' => 'required',
            'id_card' => 'required',
            'job_title' => 'required',
            'reference' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name_people.required' => 'fild name is required',
            'id_card.required' => 'fild id card is required',
            'job_title.required' => 'fild job title is required',
        ];
    }
    public function store()
    {
        $this->validate();
        if ($this->pto_id) {
           $ot = ObserverTeam::updateOrCreate(
                ['id' => $this->observer_team],
                [
                'name' => $this->name_people,
                'id_card' => $this->id_card,
                'job_title' => $this->job_title,
                'reference' => $this->reference,
            ]);
            $source = Approval::where('state', 'pending')->whereIn('new_data->reference', [$this->reference])->get();
            foreach ($source as  $value) {
                Approval::find($value->id)->approve(persist: true);
            }
            $this->reset('modal');
        } else {
            $ot = ObserverTeam::updateOrCreate(
                ['id' => $this->observer_team],
                [
                'name' => $this->name_people,
                'id_card' => $this->id_card,
                'job_title' => $this->job_title,
                'reference' => $this->reference,
            ]);
        }
      if ($this->observer_team) {
        $source = Approval::where('state', 'pending')->where('approvalable_id', $ot->id)->get();
        foreach ($source as  $value) {
            Approval::find($value->id)->approve();
        }
        $this->dispatch(
            'alert',
            [
                'text' => "Success Update People",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #00b09b, #96c93d)",
            ]
        );
      } else {
         $this->reset(['name_people', 'id_card', 'job_title']);
        $this->dispatch(
            'alert',
            [
                'text' => "Success add People",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #00b09b, #96c93d)",
            ]
        );
      }
      
        $this->dispatch('approval_pto');
    }
    public function name_Click(User $user)
    {
        $this->name_people =  $user->lookup_name;
        $this->id_card =  $user->employee_id;
    }
    public function render()
    {
        if ($this->observer_team) {
            $this->divider = "update People";
        } else {
            $this->divider = "add People";
        }

        return view('livewire.event-report.pto-report.observer-team.create', [
            'Observer' => User::searchNama(trim($this->name_people))->limit(500)->get(),
        ]);
    }

    public  function closeModal()
    {
        $this->reset('modal');
    }
}
