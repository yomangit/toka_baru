<div>
    <x-notification />
    <div class="flex flex-col sm:flex-row sm:justify-between ">
        <div class='w-96'> 
            <x-btn-add data-tip="Add data" wire:click="$dispatch('openModal', { component: 'admin.type-event-report.create-and-update' })" />
        </div>
        
            <div class="flex flex-col sm:flex-row gap-2">
                <x-inputsearch name='search' wire:model.live='search' placeholder='search event type' />
                <x-select-search wire:model.live='search_event_category'>
                    <option class="opacity-40" value="" selected>Select All</option>
                    @foreach ($EventCategory as $event_category)
                        <option value="{{ $event_category->event_category_name }}">
                            {{ $event_category->event_category_name }}</option>
                    @endforeach
                </x-select-search>
            </div>
    </div>
    <div class="overflow-x-auto">
        <table class="table table-zebra table-xs">
            <!-- head -->
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Event Category</th>
                    <th>Event Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @forelse ($EventTypeReport as $no => $eventTypeReport)
                    <tr class="text-center">
                        <th>{{ $EventTypeReport->firstItem() + $no }}</th>
                        <td>{{ $eventTypeReport->EventCategory->event_category_name }}</td>
                        <td>{{ $eventTypeReport->type_eventreport_name }}</td>
                        <td class="flex flex-row gap-1 justify-center">
                            <x-icon-btn-edit data-tip="Edit"
                                wire:click="$dispatch('openModal', { component: 'admin.type-event-report.create-and-update', arguments: { event_type: {{ $eventTypeReport->id }} }})" />
                            <x-icon-btn-delete wire:click="delete({{ $eventTypeReport->id }})"
                                wire:confirm.prompt="Are you sure delete  ?\n\nType DELETE to confirm|DELETE"
                                data-tip="Delete" />
                        </td>
                      
                    </tr>
                @empty
                    <tr class="text-center">
                        <th colspan="4" class="text-error">data not found!!! </th>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>{{ $EventTypeReport->links() }}</div>
    </div>
</div>
