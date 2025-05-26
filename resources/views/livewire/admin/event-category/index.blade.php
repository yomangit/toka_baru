<div>
    <x-notification />
    <div class="flex flex-col sm:flex-row sm:justify-between ">
        <div>  <x-btn-add data-tip="Add data" wire:click="$dispatch('openModal', { component: 'admin.event-category.create-and-update' })" /></div>
        <div>
            <x-inputsearch name='search' wire:model.live='search' />
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra table-xs">
            <!-- head -->
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @forelse ($EventCategory as $no => $cc)
                    <tr class="text-center">
                        <th>{{ $EventCategory->firstItem() + $no }}</th>
                        <td>{{ $cc->event_category_name }}</td>
                        <td class="flex flex-row gap-1 justify-center">
                            <x-icon-btn-edit data-tip="Edit"
                                wire:click="$dispatch('openModal', { component: 'admin.event-category.create-and-update', arguments: { event_category: {{ $cc->id }} }})" />
                            <x-icon-btn-delete wire:click="delete({{ $cc->id }})"
                                wire:confirm.prompt="Are you sure delete  ?\n\nType DELETE to confirm|DELETE"
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
        <div>{{ $EventCategory->links() }}</div>
    </div>
</div>
