<div>
    <x-notification />
    <div class="flex flex-col sm:flex-row sm:justify-between ">
        <div><x-btn-add data-tip="Add data"
                wire:click="$dispatch('openModal', { component: 'admin.division.create-and-update' })" /></div>
        <div>
            <div class="flex flex-col sm:flex-row">
                <x-inputsearch name='search' wire:model.live='search' />

            </div>
        </div>
    </div>

    <div class="mx-4 overflow-x-auto shadow-md sm:h-72 2xl:h-96">
        <table class="table table-xs table-pin-rows">
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
                @forelse ($Division as $no => $item)
                    <tr wire:click="selectHierarcy({{ $item->id }})"
                        class="text-center cursor-pointer hover:bg-slate-300">

                        <th>{{ $Division->firstItem() + $no }}</th>
                        <td>
                            {{ $item->DeptByBU->BusinesUnit->Company->name_company }}-{{ $item->DeptByBU->Department->department_name }}
                            @if (!empty($item->company_id))
                                -{{ $item->Company->name_company }}
                            @endif
                            @if (!empty($item->section_id))
                                -{{ $item->Section->name }}
                            @endif
                        </td>
                        <td class="flex flex-row justify-center gap-1">
                            <x-icon-btn-edit data-tip="Edit"
                                wire:click="$dispatch('openModal', { component: 'admin.division.create-and-update', arguments: { divisi: {{ $item->id }} }})" />
                            <x-icon-btn-delete wire:click="delete({{ $item->id }})"
                                wire:confirm.prompt="Are you sure delete data ?\n\nType DELETE to confirm|DELETE"
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
    </div>
    <div>{{ $Division->links() }}</div>
    @if ($divisi_id)
        <div class="h-40 shadow-md bg-base-100 ">
            <form wire:submit.prevent='store'>
                @csrf
                @method('PATCH')
                <x-input-error :messages="$errors->get('divisi_id')" class="mt-2" />
                <div class="overflow-x-auto ">
                    <table class="table table-xs">
                        <caption
                            class="font-bold text-transparent caption-top bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
                            Class Hierarchy
                        </caption>
                        <thead>
                            <tr>
                                <th>Class </th>
                                <th>Class Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Company</th>
                                <th>
                                    <div class="w-full max-w-md xl:max-w-xl form-control">
                                        <x-select wire:model='company_category_id' :error="$errors->get('company_category_id')">
                                            <option value="" selected>Select an option</option>
                                            @foreach ($Company as $company_category)
                                                <option value="{{ $company_category->id }}">
                                                    {{ $company_category->name_category_company }}</option>
                                            @endforeach
                                        </x-select>
                                        <x-label-error :messages="$errors->get('company_category_id')" class="mt-0" />
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th>Business Unit</th>
                                <th>
                                    <div class="w-full max-w-md xl:max-w-xl form-control">
                                        <x-select wire:model='busines_unit_id' :error="$errors->get('busines_unit_id')">
                                            <option value="" selected>Select an option</option>
                                            @foreach ($BusinesUnit as $bc)
                                                <option value="{{ $bc->id }}">
                                                    {{ $bc->Company->name_company }}</option>
                                            @endforeach
                                        </x-select>
                                        <x-label-error :messages="$errors->get('busines_unit_id')" class="mt-0" />
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th>Department</th>
                                <th>
                                    <div class="w-full max-w-md xl:max-w-xl form-control">
                                        <x-select wire:model='dept_by_business_unit_id' :error="$errors->get('dept_by_business_unit_id')">
                                            <option value="" selected>Select an option</option>
                                            @foreach ($Department as $bu)
                                                <option value="{{ $bu->id }}">
                                                    {{ $bu->BusinesUnit->Company->name_company }}-{{ $bu->Department->department_name }}
                                                </option>
                                            @endforeach
                                        </x-select>
                                        <x-label-error :messages="$errors->get('dept_by_business_unit_id')" class="mt-0" />
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2" class="relative pb-2">
                                    <div class="absolute inset-y-0 right-0 pr-2">
                                        @if ($heararcy_id)
                                            <button class="btn btn-link btn-xs" type="submit">Change</button>
                                            <label
                                                wire:confirm.prompt="Are you sure delete this?\n\nType DELETE to confirm|DELETE"
                                                class="btn btn-link btn-xs text-rose-500"wire:click="clear({{ $heararcy_id }})">Clear</label>
                                        @else
                                            <x-btn-save wire:target="store"
                                                wire:loading.class="btn-disabled">{{ __('Add') }}</x-btn-save>
                                        @endif
                                    </div>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    @endif
</div>
