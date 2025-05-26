<div>
    <x-notification />
    <div class="flex flex-col sm:flex-row sm:justify-between ">
        <div><x-btn-add data-tip="Add data" wire:click="$dispatch('openModal', { component: 'admin.job-class.create-and-update' })" /></div>
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
                @forelse ($JobClass as $no => $job_class)
                    <tr class="text-center">
                        <th>{{ $JobClass->firstItem() + $no }}</th>
                        <td>{{ $job_class->job_class_name }}</td>
                        <td class="flex flex-row gap-1 justify-center">
                            <x-icon-btn-edit data-tip="Edit"
                                wire:click="$dispatch('openModal', { component: 'admin.job-class.create-and-update', arguments: { jobClass: {{ $job_class->id }} }})" />
                            <x-icon-btn-delete wire:click="delete({{ $job_class->id }})"
                                wire:confirm.prompt="Are you sure delete {{ $job_class->job_class_name }}?\n\nType DELETE to confirm|DELETE"
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
        <div>{{ $JobClass->links() }}</div>
    </div>
</div>
