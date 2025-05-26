<div  >
    <div class="flex flex-col sm:flex-row sm:justify-between ">
        <div>  <x-btn-add data-tip="Add" wire:click="$dispatch('openModal', { component: 'admin.workflow-applicable.create-and-update', arguments: { template: {{ $template }} }})" /></div>
        <div >
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra table-xs">
            <!-- head -->
            <thead>
                <tr class="text-center">
                    <th>Event Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @forelse ($WorkflowApplicable as $no => $item)
                    <tr class="text-center">
                        <td class="font-serif font-semibold">{{ $item->EventType->type_eventreport_name }}</td>
                        <td class="flex flex-row gap-1 justify-center">
                            <x-icon-btn-edit data-tip="Edit"
                                wire:click="$dispatch('openModal', { component: 'admin.workflow-applicable.create-and-update', arguments: {template: {{ $template }} , wa: {{ $item->id }} }})" />
                            <x-icon-btn-delete wire:click="delete({{ $item->id }})"
                                wire:confirm.prompt="Are you sure delete  {{ $item->EventType->type_eventreport_name }} ?\n\nType DELETE to confirm|DELETE"
                                data-tip="Delete" />
                        </td>
                        
                    </tr>
                @empty
                    <tr class="text-center">
                        <th colspan="3" class="text-error">data not found!!! </th>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
