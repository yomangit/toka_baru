<?php

namespace App\Livewire\Admin\RouteRequest;

use Livewire\Component;
use App\Models\route_request;
use Livewire\Attributes\Validate;
use LivewireUI\Modal\ModalComponent;
use App\Models\WorkflowAdministration;
use Illuminate\Support\Facades\Request;
class Create extends ModalComponent
{
    #[Validate]
    public $route_name,$workflow_template_id;
    public $divider,$routeRequets_id;
    public function mount( route_request $route)
    {
       $this->routeRequets_id = $route->id;
        $this->route_name =  $route->route_name;
        $this->workflow_template_id =  $route->workflow_template_id;
    }
    public function rules()
    {
        return [
            'route_name' => ['required'],
            'workflow_template_id' => ['required'],
        ];
    }
    public function render()
    {
       
        if ($this->routeRequets_id) {
            $this->divider = "Update Route Request";
        } else {
            $this->divider = "Create Route Request";
        }
        return view('livewire.admin.route-request.create',[
            'Workflow_template'=>WorkflowAdministration::get()
        ]);
    }
    public function store()
    {
        $this->validate();
        route_request::updateOrCreate(
            ['id' => $this->routeRequets_id],
            [
                'route_name' => $this->route_name,
                'workflow_template_id' => $this->workflow_template_id,
            ]
        );
        if ($this->routeRequets_id) {
            $this->dispatch(
                'alert',
                [
                    'text' => "Data Updated Successfully!!",
                    'duration' => 3000,
                    'destination' => '/contact',
                    'newWindow' => true,
                    'close' => true,
                    'backgroundColor' => "linear-gradient(to right, #00b09b, #96c93d)",
                ]
            );
            $this->forceClose()->closeModal();
        } else {
            $this->reset(['route_name','workflow_template_id']);
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
        }
        $this->dispatch('routeList_create');
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
