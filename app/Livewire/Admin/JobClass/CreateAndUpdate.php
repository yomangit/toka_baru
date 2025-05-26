<?php

namespace App\Livewire\Admin\JobClass;

use App\Models\JobClass;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;

class CreateAndUpdate extends ModalComponent
{
    #[Validate]
    public $modal = 'modal', $job_class_name, $jobclass_id, $divider;
    public function mount(JobClass $jobClass)
    {
            $this->jobclass_id = $jobClass->id;
            $this->job_class_name = $jobClass->job_class_name;
    }
    public function render()
    {
        if ($this->jobclass_id) {
            $this->divider = "Edit Job Class";
        } else {
            $this->divider = "Add Job Class";
        }
        
        return view('livewire.admin.job-class.create-and-update');
    }
    public function rules()
    {
        return [
            'job_class_name' => ['required', 'string', 'min:2', 'max:50']
        ];
    }
    public function store()
    {
        $this->validate();
        JobClass::updateOrCreate(
            ['id' => $this->jobclass_id],
            ['job_class_name' => $this->job_class_name]
        );
        if ($this->jobclass_id) {
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
            $this->reset('job_class_name');
        }
        $this->dispatch('jobClass_created');
    }
    public static function modalMaxWidth(): string
    {
        return 'md';
    }
    public static function closeModalOnClickAway(): bool
    {
        return false;
    }
}
