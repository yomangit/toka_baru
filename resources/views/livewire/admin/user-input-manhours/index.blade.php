<div>
    <x-notification />
    <div class="flex flex-col sm:flex-row sm:justify-between ">
        <div>
            <x-btn-add data-tip="Add data" wire:click="$dispatch('openModal', { component: 'admin.user-input-manhours.create' })" />
        </div>
        <div>
            <div class="flex flex-col sm:flex-row gap-1">
                <x-inputsearch name='search' wire:model.live='search' />
                
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra table-xs">
            <!-- head -->
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Name </th>
                    <th>Company</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @forelse ($UserInput as $no => $users_input)
                    <tr class="text-center">
                        <th>{{ $UserInput->firstItem() + $no }}</th>
                        <td>{{ $users_input->User->lookup_name }}</td>
                        <td>{{ $users_input->Company->name_company }}</td>
                        <td class="flex flex-row gap-1 justify-center">
                            <x-icon-btn-edit data-tip="Edit"
                                wire:click="$dispatch('openModal', { component: 'admin.user-input-manhours.create', arguments: { user: {{ $users_input->id }} }})" />
                            <x-icon-btn-delete wire:click="delete({{ $users_input->id }})"
                                wire:confirm.prompt="Are you sure delete {{ $users_input->User->lookup_name.' - '.$users_input->Company->name_company  }}?\n\nType DELETE to confirm|DELETE"
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
    </div>
    <div>{{ $UserInput->links() }}</div>
</div>
