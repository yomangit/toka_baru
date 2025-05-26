<div>
    <x-notification />
    <div class="flex flex-col sm:flex-row sm:justify-between ">
        <div> <x-btn-add data-tip="Add data" wire:click="$dispatch('openModal', { component: 'admin.status-event.create-and-update' })" /></div>
        <div>
            <x-inputsearch wire:model.live='search' />
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="table table-zebra table-xs">
            <!-- head -->
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Name</th>
                    <th>Bacground Color</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @forelse ($StatusEvent as $no => $status)
                    <tr class="text-center font-semibold">
                        <th>{{ $StatusEvent->firstItem() + $no }}</th>
                        <td>{{ $status->status_name }}</td>
                        <td class="{{ $status->bg_status }} w-32  font-semibold">
                            {{ $status->bg_status }}
                        </td>
                        <td class="flex flex-row gap-1 justify-center">
                            <x-icon-btn-edit data-tip="Edit"
                                wire:click="$dispatch('openModal', { component: 'admin.status-event.create-and-update', arguments: { status: {{ $status->id }} }})" />
                            <x-icon-btn-delete wire:click="delete({{ $status->id }})"
                                wire:confirm.prompt="Are you sure delete {{ $status->status_name }} ?\n\nType DELETE to confirm|DELETE"
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
        <div>{{ $StatusEvent->links() }}</div>
    </div>
</div>
