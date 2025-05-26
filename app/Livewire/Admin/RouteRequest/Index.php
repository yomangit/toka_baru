<?php

namespace App\Livewire\Admin\RouteRequest;

use App\Models\route_request;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['routeList_create' => 'render'];
    public function render()
    {
        return view('livewire.admin.route-request.index',[
            'route_request' => route_request::with('WorkflowAdministration')->orderBy('route_name','ASC')->paginate(15)
        ])->extends('base.index', ['header' => 'Route Request Event', 'title' => 'Route Request Event'])->section('content');
    }
    public function delete($id)
    {
        $delete = route_request::whereId($id);
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
        $delete->delete();
    }
    public function paginationView()
    {
        return 'pagination.masterpaginate';
    }
}
