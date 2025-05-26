<div>
    <x-notification />
    <div role="tablist" class="tabs tabs-lifted">
        <input type="radio" name="my_tabs_2" role="tab" class="tab font-semibold" aria-label="Department Group"
            checked />
        <div role="tabpanel" class="p-6 tab-content bg-base-100 border-base-300 rounded-box">
            <div class="flex flex-col sm:flex-row sm:justify-between ">
                <div>
                    <x-btn-add data-tip="Add data"
                        wire:click="$dispatch('openModal', { component: 'admin.dept-group.create-and-update' })" />
                </div>
                <div>
                    <div class="flex flex-col sm:flex-row gap-2">

                        <x-inputsearch name='search' wire:model.live='search_group' />
                        <x-select-search wire:model.live='search_dept'>
                            <option class="opacity-40" value="" selected>Select All</option>
                            @foreach ($Department as $dept)
                                <option value="{{ $dept->department_name }}">
                                    {{ $dept->department_name }}
                                </option>
                            @endforeach
                        </x-select-search>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="table table-zebra table-xs">
                    <!-- head -->
                    <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th class="font-extrabold">Group</th>
                            <th class="font-extrabold">Department</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- row 1 -->
                        @forelse ($Group as $no => $group)
                            <tr>
                                <th class="text-center">{{ $Group->firstItem() + $no }}</th>
                                <td class="text-center font-bold">{{ $group->group_name }}</td>
                                <td>

                                    @foreach ($group->Dept()->get() as $dept)
                                        <div class="grid grid-cols-2  items-center hover:bg-slate-300">

                                            <div class=" text-right font-semibold m-1">
                                                {{ $dept->department_name }}
                                            </div>
                                            <div class="m-1">

                                                <x-icon-btn-edit data-tip="Edit"
                                                    wire:click="$dispatch('openModal', { component: 'admin.dept-group.create-and-update', arguments: { group: {{ $group->id }} , dept:{{ $dept->id }} }})" />
                                                <x-icon-btn-delete wire:click="delete({{ $group->id }}, {{ $dept->id }})"
                                                    wire:confirm.prompt="Are you sure delete {{ $group->name_company }}?\n\nType DELETE to confirm|DELETE"
                                                    data-tip="Delete" />
                                            </div>
                                        </div>
                                    @endforeach
                                </td>

                            </tr>
                        @empty
                            <tr class="text-center">
                                <th colspan="4" class="text-error">data not found!!! </th>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div>{{ $Group->links() }}</div>
            </div>
        </div>

        <input type="radio" name="my_tabs_2" role="tab" class="tab font-semibold" aria-label="Group" />
        <div role="tabpanel" class="p-6 tab-content bg-base-100 border-base-300 rounded-box">
            @livewire('admin.group.index')
        </div>


    </div>
</div>
