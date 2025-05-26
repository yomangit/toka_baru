<div>
    <x-notification />
    <div class="flex flex-col sm:flex-row sm:justify-between ">
        <div> 
            <x-btn-add wire:click="$dispatch('openModal', { component: 'admin.route-request.create' })"/>
        </div>
        
    </div>
    <div class="overflow-x-auto">
        <table class="table table-xs table-zebra">
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Route Name</th>
                    <th>Worflow Template Name</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($route_request as $index => $item)
                    <tr class="text-center" >
                        <th>{{ $route_request->firstItem() + $index }}</th>
                        <td>{{ $item->route_name }}</td>
                        <td>{{ $item->WorkflowAdministration->workflow_template_name }}</td>
                        <td class="flex flex-row gap-1 justify-center">
                            <x-icon-btn-edit data-tip="Edit" wire:click="$dispatch('openModal', { component: 'admin.route-request.create', arguments: { route: {{ $item->id }} }})"  />
                            <x-icon-btn-delete wire:click="delete({{ $item->id }})"
                                wire:confirm.prompt="Are you sure delete {{ $item->name }}?\n\nType DELETE to confirm|DELETE"
                                data-tip="Delete" />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <th colspan="3" class="text-error text-center">data not found!!! </th>
                    </tr>
                    @endforelse
                   
        </table>
        <div>{{ $route_request->links() }}</div>
    </div>

</div>
