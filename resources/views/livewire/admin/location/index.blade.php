<div>
    <x-notification />
    <div class="flex flex-col sm:flex-row sm:justify-between ">
        <div>  
        <x-btn-add data-tip="Add data" wire:click="$dispatch('openModal', { component: 'admin.location.create-and-update' })" />
        <x-btn-upload data-tip="Upload File" wire:click="$dispatch('openModal', { component: 'admin.location.upload' })" />
        
        </div>
        
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
                @forelse ($Location as $no => $location)
                    <tr class="text-center">
                        <th>{{ $Location->firstItem() + $no }}</th>
                        <td>{{ $location->location_name }}</td>
                        <td>
                            <div class="flex flex-row gap-1 justify-center">
                                <x-icon-btn-edit data-tip="Edit"
                                    wire:click="$dispatch('openModal', { component: 'admin.location.create-and-update', arguments: { location: {{ $location->id }}  }})" />
                                <x-icon-btn-delete wire:click="delete({{ $location->id }})"
                                    wire:confirm.prompt="Are you sure delete {{$location->location_name }}?\n\nType DELETE to confirm|DELETE"
                                    data-tip="Delete" />

                            </div>
                        </td>
                        
                    </tr>
                @empty
                    <tr class="text-center">
                        <th colspan="3" class="text-error">data not found!!! </th>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>{{ $Location->links() }}</div>
    </div>
</div>
