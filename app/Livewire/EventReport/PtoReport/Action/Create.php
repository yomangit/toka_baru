<?php

namespace App\Livewire\EventReport\PtoReport\Action;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ObserverAction;
use App\Models\pto_report;
use Cjmellor\Approval\Models\Approval;

class Create extends Component
{
    public $modal, $observer_id, $divider;
    public $report_by, $report_id;
    public $action, $due_date, $completion_date, $reference, $pto_id;
    public function mount($reference, pto_report $id)
    {
        $this->pto_id = $id->id;
        $this->reference = $reference;
    }
    public function render()
    {
        if ($this->observer_id) {
            $this->divider = "Update Action";
        } else {
            $this->divider = "Add Action";
        }

        return view('livewire.event-report.pto-report.action.create', [
            'Report_by' => User::searchFor(trim($this->report_by))->limit(1000)->get(),
        ]);
    }
    public function reportByClick(User $user)
    {
        $this->report_by = $user->lookup_name;
        $this->report_id = $user->id;
    }
    public function rules()
    {
        return [
            'action' => 'required',
            'report_by' => 'required',
            'due_date' => 'required',
        ];
    }
    public function store()
    {
        $this->validate();
        if ($this->pto_id) {
            $oa =   ObserverAction::updateOrCreate(
                ['id' => $this->observer_id],
                [
                    'action' => $this->action,
                    'by_who' => $this->report_id,
                    'due_date' =>  $this->due_date,
                    'completion_date' => ($this->completion_date == null) ? null : $this->completion_date,
                    'reference' => $this->reference,
                ]
            );
            $source = Approval::where('state', 'pending')->whereIn('new_data->reference', [$this->reference])->get();
            foreach ($source as  $value) {
                Approval::find($value->id)->approve(persist: true);
            }
            $this->reset('modal');
        } else {
          ObserverAction::updateOrCreate(
                ['id' => $this->observer_id],
                [
                    'action' => $this->action,
                    'by_who' => $this->report_id,
                    'due_date' =>  $this->due_date,
                    'completion_date' => ($this->completion_date == null) ? null : $this->completion_date,
                    'reference' => $this->reference,
                ]
            );
        }
        $oa =   ObserverAction::updateOrCreate(
            ['id' => $this->observer_id],
            [
                'action' => $this->action,
                'by_who' => $this->report_id,
                'due_date' =>  $this->due_date,
                'completion_date' => ($this->completion_date == null) ? null : $this->completion_date,
                'reference' => $this->reference,
            ]
        );
        if ($this->observer_id) {
            $source = Approval::whereIn('approvalable_id', [$oa->id])->get();
            foreach ($source as  $value) {
                Approval::find($value->id)->approve(persist: true);
            }
            $this->dispatch(
                'alert',
                [
                    'text' => "Success Update action",
                    'duration' => 3000,
                    'destination' => '/contact',
                    'newWindow' => true,
                    'close' => true,
                    'backgroundColor' => "linear-gradient(to right, #00b09b, #96c93d)",
                ]
            );
        } else {

            $this->reset(['action', 'report_id', 'report_by', 'due_date', 'completion_date']);
            $this->dispatch(
                'alert',
                [
                    'text' => "Success add action",
                    'duration' => 3000,
                    'destination' => '/contact',
                    'newWindow' => true,
                    'close' => true,
                    'backgroundColor' => "linear-gradient(to right, #00b09b, #96c93d)",
                ]
            );
        }
        $this->dispatch('action_pto');
    }
    #[On('openModalActionPTO')]
    public function openModalActionPTO(ObserverAction $observer)
    {
        $this->modal = "modal-open";
        $this->observer_id = $observer->id;
        if ($this->observer_id) {
            $this->action = $observer->action;
            $this->report_id = $observer->by_who;
            $this->report_by = $observer->users->lookup_name;
            $this->due_date = $observer->due_date;
            $this->completion_date = $observer->completion_date;
        }
    }
    public function closeModal()
    {
        $this->reset('modal');
    }
}
