<div>
    <x-notification />
    <div class="flex flex-col sm:flex-row sm:justify-between ">
        <div>
                <x-btn-add data-tip="Add data" wire:click="$dispatch('openModal', { component: 'admin.event-user-security.create-and-update' })" />
        </div>
        <div>
            <div class="flex flex-col sm:flex-row">
                <x-inputsearch name='search' wire:model.live='search' />
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra table-xs">
            <!-- head -->
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Workflow Role</th>
                    <th>Event Type</th>
                    <th>Division</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @forelse ($UserSecurity as $no => $us)
                <tr >
                    <th>{{ $UserSecurity->firstItem() + $no }}</th>
                    <td>{{ $us->User->lookup_name }}</td>
                    <td>{{ $us->ResponsibleRole->responsible_role_name }}</td>
                    <td>{{ ($us->type_event_report_id)? $us->EventType->type_eventreport_name:"" }}</td>
                    <td>
                       {{ $us->name }}
                    </td>
                    <td class="flex flex-row gap-1 justify-center">
                        <x-icon-btn-edit data-tip="Edit"
                            wire:click="$dispatch('openModal', { component: 'admin.event-user-security.create-and-update', arguments: { user_security: {{ $us->id }} }})" />
                        <x-icon-btn-delete wire:click="delete({{ $us->id }})"
                            wire:confirm.prompt="Are you sure delete ?\n\nType DELETE to confirm|DELETE"
                            data-tip="Delete" />
                    </td>
                    
                </tr>
                @empty
                <tr class="text-center">
                    <th colspan="6" class="text-error">data not found!!! </th>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div>{{ $UserSecurity->links() }}</div>
    </div> 
    <div class="{{ $modal }}" role="dialog">
        <div class="modal-box h-[35rem]  relative">
            <div class="font-bold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
                Update User Security</div>
            <form wire:submit.prevent='store'>
                @csrf
                @method('PATCH')
                <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                    <x-label-req :value="__('Workgroup')" />
                    <div class="dropdown dropdown-end">
                        <x-input wire:model.live='workgroup_name' :error="$errors->get('workgroup_name')"
                            class="cursor-pointer"  tabindex="0" role="button" />
                        <div tabindex="0"
                            class="z-10 w-full shadow dropdown-content card card-compact bg-primary text-primary-content">
                                <div class="flex flex-col w-full gap-1 lg:flex-row">
                                    <div class="grid flex-grow h-40 card bg-base-300 rounded-box ">
                                        <ul class="list-none text-[9px] list-inside overflow-auto">
                                            <li class="cursor-pointer hover:bg-base-200 px-2">Company</li>
                                            @foreach ($ParentCompany as $item)
                                            <li wire:click="parentCompany({{ $item->id }})" class="cursor-pointer hover:bg-base-200 px-4 ">{{ $item->name_category_company }}</li>
                                            @endforeach 
                                            <li class="cursor-pointer hover:bg-base-200 px-2">Business Unit</li>
                                            @foreach ($BusinessUnit as $item)
                                            <li wire:click="businessUnit({{ $item->id }})" class="cursor-pointer hover:bg-base-200 px-4">{{ $item->Company->name_company }}</li>
                                            @endforeach
                                            <li class="cursor-pointer hover:bg-base-200 px-2">Department</li>
                                            @foreach ($Department as $item)
                                            <li wire:click="department({{ $item->id }})" class="cursor-pointer hover:bg-base-200 px-4">{{ $item->BusinesUnit->Company->name_company }}-{{ $item->Department->department_name }}</li>
                                            @endforeach
                                          </ul>
                                    </div>
                                    <div class="grid flex-grow h-40 card bg-base-300 rounded-box overflow-auto">
                                        <x-select-multiple wire:model.live='division_id'
                                            :error="$errors->get('division_id')">
                                            @foreach ($Division as $item)
                                               <option class="text-wrap hover:bg-primary" value="{{ $item->id }}">{{ $item->DeptByBU->BusinesUnit->Company->name_company }}-{{  $item->DeptByBU->Department->department_name  }} @if(!empty($item->company_id))-{{ $item->Company->name_company }}@endif</option>
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
                    <ul class=" menu menu-xs   rounded-box z-[1] mt-0.5 w-full p-2 shadow   @error('user_id_update') border border-rose-500  @enderror  ">
                        <li class="menu-title">
                            <div class="mb-2">
                                <x-inputsearch name='search' wire:model.live='search_people' placeholder="{{ __('search_people') }}" />
                            </div>
                        </li>
                        <li class="menu-item">

                            <ul class="overflow-x-auto list-inside h-28">
                                @forelse ($User as $users)
                                <li class="text-xs cursor-pointer hover:bg-slate-200">
                                    <label class="flex items-start cursor-pointer">
                                        <input type="radio" wire:model.live="user_id_update" value="{{ $users->id }}" checked="checked" class=" radio radio-primary radio-xs" />
                                        <span class="label-text">{{ $users->lookup_name }}</span>
                                    </label>
                                </li>
                                @empty
                                <li class="text-transparent bg-clip-text bg-gradient-to-r from-rose-400 to-rose-800">
                                    {{ __('dataNotFound') }}</li>
                                @endforelse
                            </ul>
                        </li>
                        <div class="m-2">{{ $User->links('pagination.minipaginate') }}</div>

                    </ul>

                    <x-label-error :messages="$errors->get('user_id_update')" />

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
                <div class="absolute bottom-0 right-0 m-2 modal-action">
                    <button type="submit" class="btn btn-xs btn-success btn-outline">Save</button>
                    <label wire:click='closeModal' class="btn btn-xs btn-error btn-outline">Close</label>
                </div>
            </form>
        </div>
    </div>

   


</div>
