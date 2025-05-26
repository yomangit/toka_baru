<div>
    <x-notification />

    <div class="flex flex-col sm:flex-row sm:justify-between ">
        <div>
            <x-btn-add data-tip="Add data"
                wire:click="$dispatch('openModal', { component: 'admin.sub-con-dept.create-and-update' })" />
        </div>
       
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra table-xs">
            <!-- head -->
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th class="font-extrabold">Department</th>
                    <th class="font-extrabold">Company</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @forelse ($Department as $no => $dept)
                    <tr>
                        <th class="text-center">{{ $Department->firstItem() + $no }}</th>
                        <td class="text-center font-bold">{{ $dept->department_name }}</td>
                        <td class="w-96 ">
                            @forelse ($dept->Company()->get() as $company)
                                <div class="grid grid-cols-2 items-center hover:bg-slate-300">
                                    <div class="  font-semibold m-1">
                                        {{ $company->name_company }}
                                    </div>
                                    <div class="m-1">
                                        <x-icon-btn-edit data-tip="Edit"
                                            wire:click="$dispatch('openModal', { component: 'admin.sub-con-dept.create-and-update', arguments: { company: {{ $company->id }} , dept:{{ $dept->id }} }})" />
                                        <x-icon-btn-delete wire:click="delete({{ $dept->id }}, {{ $company->id }})"
                                            wire:confirm.prompt="Are you sure delete {{ $company->name_company }}?\n\nType DELETE to confirm|DELETE"
                                            data-tip="Delete" />
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="text-center bg-clip-text text-transparent bg-gradient-to-r from-pink-500 to-violet-500 font-semibold">
                                    No Subcontractors</div>
                            @endforelse
                        </td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <th colspan="4" class="text-error">data not found!!! </th>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>{{ $Department->links() }}</div>
    </div>

</div>
