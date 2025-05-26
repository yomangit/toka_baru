<div>
    <x-notification />
    <div class="flex flex-col sm:flex-row sm:justify-between ">
        <div>
            <x-btn-add data-tip="Add data" wire:click="$dispatch('openModal', { component: 'admin.event-sub-type.create-and-update' })" />
        </div>
            <div class="flex flex-col sm:flex-row gap-2">
                <x-inputsearch name='search' wire:model.live='search' placeholder='event sub type' />
                <x-select-search wire:model.live='searchEventSubtipe'>
                    <option class="opacity-40" value="" selected>Select All</option>
                    @foreach ($EventType as $event_type) 
                        <option value="{{ $event_type->id }}">
                           {{$event_type->EventCategory->event_category_name." - ".$event_type->type_eventreport_name}} 
                        </option>
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
                    <th>Event Type</th>
                    <th>Event Subtype</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @forelse ($EventSubType as $no => $eventsubtype)
                    <tr class="text-center">
                        <th>{{ $EventSubType->firstItem() + $no }}</th>
                        <td>{{ $eventsubtype->eventtype->type_eventreport_name }}</td>
                        <td>{{ $eventsubtype->event_sub_type_name }}</td>
                        <td class="flex flex-row gap-1 justify-center">
                            <x-icon-btn-edit data-tip="Edit"
                                wire:click="$dispatch('openModal', { component: 'admin.event-sub-type.create-and-update', arguments: { event_sub_type: {{ $eventsubtype->id }} }})" />
                            <x-icon-btn-delete wire:click="delete({{ $eventsubtype->id }})"
                                wire:confirm.prompt="Are you sure delete {{ $eventsubtype->event_sub_type_name }} ?\n\nType DELETE to confirm|DELETE"
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
        <div>{{ $EventSubType->links() }}</div>
    </div>
</div>
