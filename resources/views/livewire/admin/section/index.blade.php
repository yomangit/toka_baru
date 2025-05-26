<div>
    <x-notification />
    <div class="flex flex-col sm:flex-row sm:justify-between ">
        <div> 
            <x-btn-add wire:click="$dispatch('openModal', { component: 'admin.section.create' })"/>
        </div>
        <div>
            <div class="flex flex-col sm:flex-row">
                <x-inputsearch wire:model.live='search_name' />
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="table table-xs table-zebra">
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($Section as $index => $item)
                    <tr class="text-center" wire:target='search_name' wire:loading.class="hidden">
                        <th>{{ $Section->firstItem() + $index }}</th>
                        <td>{{ $item->name }}</td>
                        <td class="flex flex-row gap-1 justify-center">
                            <x-icon-btn-edit data-tip="Edit" wire:click="$dispatch('openModal', { component: 'admin.section.create', arguments: { section: {{ $item->id }} }})"  />
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
                    <tr class="text-center hidden" wire:target='search_name' wire:loading.class.remove="hidden">
                        <th colspan="3" class="text-error text-center"><x-loading-spinner/></th>
                    </tr>
        </table>
        <div>{{ $Section->links() }}</div>
    </div>

</div>
