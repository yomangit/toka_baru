<div>
    <x-notification />
    <div class="flex flex-col sm:flex-row sm:justify-between ">
        <div>
            <x-btn-add data-tip="Add data" wire:click="$dispatch('openModal', { component: 'admin.business-unit.create-and-update' })" />
           
        </div>
        <div class="w-max-xs">
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
               
                @forelse ($BusinessUnit as $no => $bc)
                    <tr class="text-center">
                        <th>{{ $BusinessUnit->firstItem() + $no }}</th>
                        <td>{{ $bc->Company->name_company }}</td>
                        <td class="flex flex-row gap-1 justify-center">
                            <x-icon-btn-edit data-tip="Edit"
                                wire:click="$dispatch('openModal', { component: 'admin.business-unit.create-and-update', arguments: { bu: {{ $bc->id }} }})" />
                            <x-icon-btn-delete wire:click="delete({{ $bc->id }})"
                                wire:confirm.prompt="Are you sure delete {{ $bc->Company->name_company }}?\n\nType DELETE to confirm|DELETE"
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
        <div>{{ $BusinessUnit->links() }}</div>
    </div>
</div>
