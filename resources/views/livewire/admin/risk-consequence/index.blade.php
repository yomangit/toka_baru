<div>
    <x-notification />
    <div class="flex flex-col sm:flex-row sm:justify-between ">
        <div> <x-btn-add data-tip="Add data"
                wire:click="$dispatch('openModal', { component: 'admin.risk-consequence.create-and-update' })" /></div>
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
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @forelse ($Risk_con as $no => $risk)
                    <tr>
                        <th>{{ $Risk_con->firstItem() + $no }}</th>
                        <td class="text-[9px] w-28">{{ $risk->risk_consequence_name }}</td>
                        <td class="text-justify w-full max-w-md">{{ $risk->description }}</td>
                        <td class="flex flex-row gap-1 justify-center items-center ">
                            <x-icon-btn-edit data-tip="Edit"
                                wire:click="$dispatch('openModal', { component: 'admin.risk-consequence.create-and-update', arguments: { Risk_Consequence: {{ $risk->id }} }})" />
                            <x-icon-btn-delete wire:click="delete({{ $risk->id }})"
                                wire:confirm.prompt="Are you sure delete {{ $risk->risk_consequence_name }} ?\n\nType DELETE to confirm|DELETE"
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
        <div>{{ $Risk_con->links() }}</div>
    </div>
</div>
