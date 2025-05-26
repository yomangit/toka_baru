<div>
    <x-notification />

    <div class="flex flex-col sm:flex-row sm:justify-between ">
        <div><x-btn-add data-tip="Add data"
                wire:click="$dispatch('openModal', { component: 'admin.dept-by-b-u.create-and-update' })" /></div>
        <div>
            {{-- <div class="flex flex-col sm:flex-row">

                <x-inputsearch name='search' wire:model.live='search_group' />
                <x-select-search wire:model.live='search_dept'>
                    <option class="opacity-40" value="" selected>Select All</option>
                    @foreach ($Department as $dept)
                        <option value="{{ $dept->department_name }}">
                            {{ $dept->department_name }}
                        </option>
                    @endforeach
                </x-select-search>
            </div> --}}
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra table-xs">
            <!-- head -->
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th class="font-extrabold">Busines Unit</th>
                    <th class="font-extrabold">Department</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @forelse ($BusinesUnit as $no => $bu)
                    <tr>
                        <th class="text-center">{{ $BusinesUnit->firstItem() + $no }}</th>
                        <td class="text-center font-bold">{{ $bu->Company->name_company }}</td>
                        <td class="w-96 ">

                            @forelse ($bu->Department()->get() as $dept)
                                <div class="grid grid-cols-2 items-center hover:bg-slate-300">

                                    <div class="  font-semibold m-1">
                                        {{ $dept->department_name }}
                                    </div>
                                    <div class="m-1">
                                        <x-icon-btn-edit data-tip="Edit"
                                            wire:click="$dispatch('openModal', { component: 'admin.dept-by-b-u.create-and-update', arguments: { bu: {{ $bu->id }} , dept:{{ $dept->id }} }})" />
                                        <x-icon-btn-delete wire:click="delete({{ $bu->id }}, {{ $dept->id }})"
                                            wire:confirm.prompt="Are you sure delete  {{ $dept->department_name }}?\n\nType DELETE to confirm|DELETE"
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
        <div>{{ $BusinesUnit->links() }}</div>
    </div>

</div>
