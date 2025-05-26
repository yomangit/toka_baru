<div>
    <div wire:target="store" wire:loading.class="skeleton" class="p-2">
        <div
            class="py-4 font-extrabold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
            {{ $divider }}</div>
        <form wire:submit.prevent='store'>
            @csrf
            <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                <x-label-req :value="__('Workgroup')" />
                <div class="dropdown dropdown-end">
                    <x-input wire:model.live='workgroup_name' :error="$errors->get('workgroup_name')" class="cursor-pointer" tabindex="0"
                        role="button" />
                    <div tabindex="0"
                        class="z-10 w-full shadow dropdown-content card card-compact bg-primary text-primary-content">
                        <div class="flex flex-col w-full gap-1 lg:flex-row">
                            <div class="grid flex-grow h-40 card bg-base-300 rounded-box ">
                                <ul class="list-none text-[9px] list-inside overflow-auto">
                                    <li class="cursor-pointer hover:bg-base-200 px-2">Company</li>
                                    @foreach ($ParentCompany as $item)
                                        <li wire:click="parentCompany({{ $item->id }})"
                                            class="cursor-pointer hover:bg-base-200 px-4 ">
                                            {{ $item->name_category_company }}</li>
                                    @endforeach
                                    <li class="cursor-pointer hover:bg-base-200 px-2">Business Unit</li>
                                    @foreach ($BusinessUnit as $item)
                                        <li wire:click="businessUnit({{ $item->id }})"
                                            class="cursor-pointer hover:bg-base-200 px-4">
                                            {{ $item->Company->name_company }}</li>
                                    @endforeach
                                    <li class="cursor-pointer hover:bg-base-200 px-2">Department</li>
                                    @foreach ($Department as $item)
                                        <li wire:click="department({{ $item->id }})"
                                            class="cursor-pointer hover:bg-base-200 px-4">
                                            {{ $item->BusinesUnit->Company->name_company }}-{{ $item->Department->department_name }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="grid flex-grow h-40 card bg-base-300 rounded-box overflow-auto">
                                <x-select-multiple wire:model.live='division_id' :error="$errors->get('division_id')">
                                    @foreach ($Division as $item)
                                        <option class="text-wrap hover:bg-primary" value="{{ $item->id }}">
                                            {{ $item->DeptByBU->BusinesUnit->Company->name_company }}-{{ $item->DeptByBU->Department->department_name }}
                                            @if (!empty($item->company_id))
                                                -{{ $item->Company->name_company }}
                                            @endif
                                            @if (!empty($item->section_id))
                                            -{{ $item->Section->name }}
                                        @endif
                                        </option>
                                    @endforeach
                                </x-select-multiple>
                            </div>
                        </div>
                    </div>
                </div>
                <x-label-error :messages="$errors->get('workgroup_name')" />
            </div>
            <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                <x-label-req :value="__('People')" />
                <ul
                    class=" menu menu-xs   rounded-box z-[1] mt-0.5 w-full p-2 shadow   @error('user_id') border border-rose-500   @enderror ">
                    <li class="menu-title">
                        <div class="mb-2">
                            <x-inputsearch name='search' wire:model.live='search_people'
                                placeholder="{{ __('search_people') }}" />
                        </div>
                    </li>
                    <li class="menu-item ">
                        
                        <ul wire:loading.class="hidden" wire:target="search_people"  class="overflow-x-auto list-inside h-28">
                            @forelse ($User as $users)
                                <li class="text-xs cursor-pointer hover:bg-slate-200">
                                    @if ($event_user_security_id)
                                        <label class="flex items-start cursor-pointer">
                                            <input type="radio" wire:model.live="user_id_update"
                                            checked="checked"
                                                value="{{ $users->id }}" class=" radio radio-primary radio-xs" />
                                            <span class="label-text">{{ $users->lookup_name }}</span>
                                        </label>
                                    @else
                                        <label class="flex items-start cursor-pointer">
                                            <input type="checkbox" wire:model.live="user_id"
                                                value="{{ $users->id }}"
                                                class=" checkbox [--chkbg:oklch(var(--a))] [--chkfg:oklch(var(--p))] checkbox-xs" />
                                            <span class="label-text">{{ $users->lookup_name }}</span>
                                        </label>
                                    @endif
                                </li>
                            @empty
                                <li class="text-transparent bg-clip-text bg-gradient-to-r from-rose-400 to-rose-800">
                                    {{ __('dataNotFound') }}</li>
                            @endforelse
                        </ul>
                    </li>
                    <div class="hidden text-center w-full"  wire:target='search_people' wire:loading.class.remove='hidden'> <x-loading-spinner /></div>
                    <div class="m-2">{{ $User->links('pagination.minipaginate') }}</div>

                </ul>
                <x-label-error :messages="$errors->get('user_id')" />
            </div>
            <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                <x-label-req :value="__('Workflow Role')" />
                <x-select wire:model='responsible_role_id' :error="$errors->get('responsible_role_id')">
                    <option value="" selected>Select an option</option>
                    @foreach ($ResponsibleRole as $rr)
                        <option value="{{ $rr->id }}" selected>{{ $rr->responsible_role_name }}</option>
                    @endforeach
                </x-select>
                <x-label-error :messages="$errors->get('responsible_role_id')" />
            </div>
            <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                <x-label-req :value="__('Event Type')" />
                <x-select wire:model='type_event_report_id' :error="$errors->get('type_event_report_id')">
                    <option value="" selected>Select an option</option>
                    @foreach ($TypeEventReport as $item)
                        <option value="{{ $item->id }}" selected>{{ $item->type_eventreport_name }}</option>
                    @endforeach
                </x-select>
                <x-label-error :messages="$errors->get('type_event_report_id')" />
            </div>
            <div class="modal-action">
                <x-btn-save wire:target="store" wire:loading.class="btn-disabled">{{ __('Save') }}</x-btn-save>
                    <x-btn-close wire:target="store" wire:loading.class="btn-disabled" wire:click="$dispatch('closeModal')"
                        >{{ __('Close') }}</x-btn-close>
            </div>
        </form>
    </div>
</div>
