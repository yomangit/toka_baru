<div>
    <x-notification />


    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <style>
        .ck-editor__editable[role="textbox"] {
            /* Editing area */
            /* min-height: 200px; */
            padding-left: 40px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    @section('bradcrumbs')
        {{ Breadcrumbs::render('PtoReportform') }}
    @endsection
    <div
        class="py-1 text-sm font-extrabold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-rose-500 to-orange-500">
        {{ $divider }} </div>
    <form wire:submit.prevent='store'>
        <div wire:target='store' wire:loading.class="skeleton">
            {{-- OBSERVER --}}
            <div role="tablist" class="mb-4 tabs tabs-lifted">
                <input type="radio" name="my_tabs_1" role="tab"
                    class="font-semibold tab font-signika text-rose-500 " aria-label="1.&ensp;Observer"
                    checked="checked" />
                <div role="tabpanel" class="p-6 tab-content bg-base-100 border-base-300 rounded-box ">
                    <div class="grid gap-1 sm:grid-cols-2 lg:grid-cols-4">

                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('Name')" />
                            <div class="dropdown dropdown-end">
                                <x-input-search-with-error placeholder="search name" wire:model.live='name_observer'
                                    :error="$errors->get('name_observer')" class="cursor-pointer read-only:bg-gray-200 " tabindex="0"
                                    role="button" />
                                <div tabindex="0"
                                    class="dropdown-content card card-compact  bg-base-300 text-primary-content z-[1] w-full  p-2 shadow">
                                    <div class="relative">
                                        <div class="h-32 pt-2 mb-2 overflow-auto scroll-smooth focus:scroll-auto"
                                            wire:target='name_observer' wire:loading.class='hidden'>
                                            @forelse ($Observer as $spv_area)
                                                <div wire:click="name_observerClick({{ $spv_area->id }})"
                                                    class="flex flex-col border-b cursor-pointer border-base-200 active:bg-gray-400">
                                                    <strong
                                                        class="text-[10px] text-slate-800">{{ $spv_area->lookup_name }}</strong>
                                                </div>
                                            @empty
                                                <strong
                                                    class="text-xs text-transparent bg-clip-text bg-gradient-to-r from-rose-400 to-rose-800">Name
                                                    Not Found!!!</strong>
                                            @endforelse
                                        </div>
                                        <div class="hidden pt-5 text-center" wire:target='name_observer'
                                            wire:loading.class.remove='hidden'>
                                            <x-loading-spinner />
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <x-label-error :messages="$errors->get('supervisor_area')" />
                        </div>
                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('Job Title')" />
                            <x-input wire:model.blur='job_title' :error="$errors->get('job_title')" />
                            <x-label-error :messages="$errors->get('job_title')" />
                        </div>
                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('date & time')" />
                            <x-input-date id="tanggal" wire:model.live='date_time' readonly :error="$errors->get('date_time')" />
                            <x-label-error :messages="$errors->get('date_time')" />
                        </div>
                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('Responsibility Workgroup')" />
                            <div class="dropdown dropdown-end">
                                <x-input wire:model.live='workgroup_name' wire:keydown.self="changeConditionDivision"
                                    :error="$errors->get('workgroup_name')" class="cursor-pointer" tabindex="0" role="button" />
                                <div tabindex="0"
                                    class="z-10 w-full shadow dropdown-content card card-compact bg-primary text-primary-content">
                                    <div class="flex flex-col w-full gap-1 lg:flex-row">
                                        <div class="grid flex-grow h-40 card bg-base-300 rounded-box ">
                                            <ul class="list-none text-[9px] list-inside overflow-auto">
                                                <li class="px-2 cursor-pointer hover:bg-base-200">Company</li>
                                                @foreach ($ParentCompany as $item)
                                                    <li wire:click="parentCompany({{ $item->id }})"
                                                        class="px-4 cursor-pointer hover:bg-base-200 ">
                                                        {{ $item->name_category_company }}</li>
                                                @endforeach
                                                <li class="px-2 cursor-pointer hover:bg-base-200">Business Unit</li>
                                                @foreach ($BusinessUnit as $bu)
                                                    <li wire:click="businessUnit({{ $bu->name_company_id }})"
                                                        class="px-4 cursor-pointer hover:bg-base-200">
                                                        {{ $bu->Company->name_company }}</li>
                                                @endforeach
                                                <li class="px-2 cursor-pointer hover:bg-base-200">Department</li>
                                                @foreach ($Department as $item)
                                                    <li wire:click="department({{ $item->id }})"
                                                        class="px-4 cursor-pointer hover:bg-base-200">
                                                        {{ $item->BusinesUnit->Company->name_company }}-{{ $item->Department->department_name }}
                                                    </li>
                                                @endforeach

                                                <li class="px-2 cursor-pointer hover:bg-base-200">Division</li>
                                                @foreach ($Divisi as $divisi)
                                                    <li wire:click="divisi({{ $divisi->company_id }})"
                                                        class="px-4 cursor-pointer hover:bg-base-200">
                                                        {{ $divisi->DeptByBU->BusinesUnit->Company->name_company . '-' . $divisi->DeptByBU->Department->department_name . '-' . $divisi->Company->name_company }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="grid flex-grow h-40 overflow-auto card bg-base-300 rounded-box">
                                            <ul class="w-56 px-4 py-2 list-disc list-inside bg-base-200 rounded-box">

                                                @forelse ($Division as $item)
                                                    <li wire:click="select_division({{ $item->id }})"
                                                        class="text-[9px] text-wrap hover:bg-primary subpixel-antialiased text-left cursor-pointer">
                                                        {{ $item->DeptByBU->BusinesUnit->Company->name_company }}-{{ $item->DeptByBU->Department->department_name }}
                                                        @if (!empty($item->company_id))
                                                            -{{ $item->Company->name_company }}
                                                        @endif
                                                        @if (!empty($item->section_id))
                                                            -{{ $item->Section->name }}
                                                        @endif
                                                    </li>
                                                @empty
                                                    <li class='font-semibold text-center text-rose-500'>Division not
                                                        found!! </li>
                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <x-label-error :messages="$errors->get('workgroup_name')" />
                        </div>
                    </div>
                    <div class="mt-2 card bg-base-100 ">
                        <div class="p-2 border border-gray-300 card-body rounded-box">
                            <label class="text-lg card-title font-signika">Observer Team</label>
                            <x-btn-add data-tip="Add people" wire:click="$dispatch('openModalPtoTeam')" />
                            <livewire:event-report.pto-report.observer-team.index :reference="$reference">
                        </div>
                    </div>
                </div>
            </div>
            {{-- TASK BEING OBSERVED --}}
            <div role="tablist" class="mb-4 tabs tabs-lifted">

                <input type="radio" name="my_tabs_2" role="tab"
                    class="font-semibold tab font-signika text-rose-500 " aria-label="2.&ensp;Task Being Observed"
                    checked="checked" />
                <div role="tabpanel" class="p-6 tab-content bg-base-100 border-base-300 rounded-box">
                    <div class="grid gap-1 sm:grid-cols-2 lg:grid-cols-3">
                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('Task Name')" />
                            <x-input wire:model.blur='task_name' :error="$errors->get('task_name')" />
                            <x-label-error :messages="$errors->get('task_name')" />
                        </div>
                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('supervisor area')" />
                            <div class="dropdown dropdown-end">
                                <x-input-search-with-error placeholder="search Supervisor"
                                    wire:model.live='supervisor_area' :error="$errors->get('supervisor_area')"
                                    class="cursor-pointer read-only:bg-gray-200 " tabindex="0" role="button" />
                                <div tabindex="0"
                                    class="dropdown-content card card-compact  bg-base-300 text-primary-content z-[1] w-full  p-2 shadow">
                                    <div class="relative">
                                        <div class="h-32 pt-2 mb-2 overflow-auto scroll-smooth focus:scroll-auto"
                                            wire:target='supervisor_area' wire:loading.class='hidden'>
                                            @forelse ($Supervisor_Area as $spv_area)
                                                <div wire:click="spvClick({{ $spv_area->id }})"
                                                    class="flex flex-col border-b cursor-pointer border-base-200 ">
                                                    <strong
                                                        class="text-[10px] text-slate-800">{{ $spv_area->lookup_name }}</strong>
                                                </div>
                                            @empty
                                                <strong
                                                    class="text-xs text-transparent bg-clip-text bg-gradient-to-r from-rose-400 to-rose-800">Name
                                                    Not Found!!!</strong>
                                            @endforelse
                                        </div>
                                        <div class="hidden pt-5 text-center" wire:target='supervisor_area'
                                            wire:loading.class.remove='hidden'>
                                            <x-loading-spinner />
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <x-label-error :messages="$errors->get('supervisor_area')" />
                        </div>
                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('no of worker')" />
                            <x-input wire:model.live='number_of_worker' type="number" :error="$errors->get('number_of_worker')" />
                            <x-label-error :messages="$errors->get('number_of_worker')" />
                        </div>
                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('Location')" />
                            <x-select wire:model.live='location_id' :error="$errors->get('location_id')">
                                <option value="" selected>Select an option</option>
                                @forelse ($Location as $location)
                                    <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                                @endforeach
                            </x-select>
                            <x-label-error :messages="$errors->get('location_id')" />
                        </div>
                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('type of observation')" />
                            <fieldset
                                class="flex items-start p-[3px] border border-gray-300 rounded-sm   shadow-sm @error('type_of_observation') border-rose-500  @enderror gap-1">
                                <input wire:model.live="type_of_observation" name="radio-10" id="new"
                                    class="radio-xs peer/new checked:bg-emerald-500 radio" type="radio"
                                    name="status" value="New" />
                                <label for="new"
                                    class="text-xs font-semibold peer-checked/new:text-emerald-500">{{ __('New') }}</label>

                                <input wire:model.live="type_of_observation" name="radio-10" id="no"
                                    class="radio-xs peer/no checked:bg-sky-500 radio" type="radio" name="status"
                                    value="Follow Up" />
                                <label for="no"
                                    class="text-xs font-semibold peer-checked/no:text-sky-500">{{ __('Follow Up') }}</label>

                            </fieldset>
                            <x-label-error :messages="$errors->get('type_of_observation')" class="mt-0" />
                        </div>
                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('scope of observation')" />
                            <fieldset
                                class="flex items-start p-[3px] border border-gray-300 rounded-sm   shadow-sm @error('scope_of_observation') border-rose-500  @enderror gap-1">
                                <input wire:model.live="scope_of_observation" name="radio-11" id="Partial"
                                    class="radio-xs peer/Partial checked:bg-emerald-500 radio" type="radio"
                                    name="Partial" value="Partial" />
                                <label for="Partial"
                                    class="text-xs font-semibold peer-checked/Partial:text-emerald-500">{{ __('Partial') }}</label>

                                <input wire:model.live="scope_of_observation" name="radio-11" id="Full"
                                    class="radio-xs peer/Full checked:bg-sky-500 radio" type="radio" name="Full"
                                    value="Full" />
                                <label for="Full"
                                    class="text-xs font-semibold peer-checked/Full:text-sky-500">{{ __('Full') }}</label>

                            </fieldset>
                            <x-label-error :messages="$errors->get('scope_of_observation')" class="mt-0" />
                        </div>
                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('job guidance')" />
                            <fieldset
                                class="flex items-start p-[3px] border border-gray-300 rounded-sm   shadow-sm @error('job_guidance') border-rose-500  @enderror gap-1">
                                <input wire:model.live="job_guidance" name="radio-12" id="JSEA"
                                    class="radio-xs peer/JSEA checked:bg-emerald-500 radio" type="radio"
                                    name="JSEA" value="JSEA/WI" />
                                <label for="JSEA"
                                    class="text-xs font-semibold peer-checked/JSEA:text-emerald-500">{{ __('JSEA/WI') }}</label>

                                <input wire:model.live="job_guidance" name="radio-12" id="SOP"
                                    class="radio-xs peer/SOP checked:bg-sky-500 radio" type="radio" name="SOP"
                                    value="SOP" />
                                <label for="SOP"
                                    class="text-xs font-semibold peer-checked/SOP:text-sky-500">{{ __('SOP or COP') }}</label>

                            </fieldset>
                            <x-label-error :messages="$errors->get('job_guidance')" class="mt-0" />
                        </div>
                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('reason of observation')" />
                            <x-select wire:model.live='reason_of_observation' :error="$errors->get('reason_of_observation')">
                                <option value="" selected>Select an option</option>
                                <option value="Follow Up Incident">Follow Up Incident</option>
                                <option value="Critical Task Audit">Critical Task Audit</option>
                                <option value="Follow Up Training">Follow Up Training</option>
                                <option value="Non Rountie Task">Non Rountie Task</option>

                            </x-select>
                            <x-label-error :messages="$errors->get('reason_of_observation')" />
                        </div>
                    </div>
                </div>
            </div>
            {{-- TYPE OF ACTIVITIES --}}
            <div role="tablist" class="mb-4 tabs tabs-lifted">
                <input type="radio" name="my_tabs_3" role="tab"
                    class="tab font-signika font-semibold text-rose-500  tab-active @error('type_of_activities')[--tab-border-color:#f43f5e]@enderror"
                    aria-label="3.&ensp;Types Of Activities" checked="checked" />
                <div role="tabpanel"
                    class="tab-content bg-base-100 border-base-300  @error('type_of_activities') border-rose-500  @enderror  rounded-box p-6 ">

                    <fieldset class=" p-[2px] gap-1">
                        <div class="grid sm:grid-cols-2 lg:grid-cols-4">
                            <div class="flex items-center gap-1 pb-2">
                                <input wire:model.live="type_of_activities" name="radio-13" id="1"
                                    class="radio-xs peer/1 checked:bg-emerald-500 radio" type="radio"
                                    name="1" value="Working at height" />
                                <label for="1"
                                    class="text-xs font-semibold peer-checked/1:text-emerald-500">{{ __('Working at height') }}</label>
                            </div>
                            <div class="flex items-center gap-1 pb-2">
                                <input wire:model.live="type_of_activities" name="radio-13" id="2"
                                    class="radio-xs peer/2 checked:bg-sky-500 radio" type="radio" name="2"
                                    value="Isolation, Lock Out and Tag Out" />
                                <label for="2"
                                    class="text-xs font-semibold peer-checked/2:text-sky-500">{{ __('Isolation, Lock Out and Tag Out') }}</label>
                            </div>
                            <div class="flex items-center gap-1 pb-2">
                                <input wire:model.live="type_of_activities" name="radio-13" id="3"
                                    class="radio-xs peer/3 checked:bg-orange-500 radio" type="radio" name="3"
                                    value="Working Near Hot Water" />
                                <label for="3"
                                    class="text-xs font-semibold peer-checked/3:text-orange-500">{{ __('Working Near Hot Water') }}</label>
                            </div>
                            <div class="flex items-center gap-1 pb-2">
                                <input wire:model.live="type_of_activities" name="radio-13" id="4"
                                    class="radio-xs peer/4 checked:bg-lime-500 radio" type="radio" name="4"
                                    value="Electrical Safety" />
                                <label for="4"
                                    class="text-xs font-semibold peer-checked/4:text-lime-500">{{ __('Electrical Safety') }}</label>
                            </div>
                            <div class="flex items-center gap-1 pb-2">
                                <input wire:model.live="type_of_activities" name="radio-13" id="5"
                                    class="radio-xs peer/5 checked:bg-cyan-500 radio" type="radio" name="5"
                                    value="Working in Confined Space" />
                                <label for="5"
                                    class="text-xs font-semibold peer-checked/5:text-cyan-500">{{ __('Working in Confined Space') }}</label>
                            </div>
                            <div class="flex items-center gap-1 pb-2">
                                <input wire:model.live="type_of_activities" name="radio-13" id="6"
                                    class="radio-xs peer/6 checked:bg-amber-500 radio" type="radio" name="6"
                                    value="Working near TSF Mud" />
                                <label for="6"
                                    class="text-xs font-semibold peer-checked/6:text-amber-500">{{ __('Working near TSF Mud') }}</label>
                            </div>
                            <div class="flex items-center gap-1 pb-2">
                                <input wire:model.live="type_of_activities" name="radio-13" id="7"
                                    class="radio-xs peer/7 checked:bg-red-500 radio" type="radio" name="7"
                                    value="Operating vehicle Mobile" />
                                <label for="7"
                                    class="text-xs font-semibold peer-checked/7:text-red-500">{{ __('Operating vehicle Mobile') }}</label>
                            </div>
                            <div class="flex items-center gap-1 pb-2">
                                <input wire:model.live="type_of_activities" name="radio-13" id="8"
                                    class="radio-xs peer/8 checked:bg-yellow-500 radio" type="radio" name="8"
                                    value="Blasting Activities" />
                                <label for="8"
                                    class="text-xs font-semibold peer-checked/8:text-yellow-500">{{ __('Blasting Activities') }}</label>
                            </div>
                            <div class="flex items-center gap-1 pb-2">
                                <input wire:model.live="type_of_activities" name="radio-13" id="9"
                                    class="radio-xs peer/9 checked:bg-green-500 radio" type="radio" name="9"
                                    value="Lifting Supporting Load" />
                                <label for="9"
                                    class="text-xs font-semibold peer-checked/9:text-green-500">{{ __('Lifting Supporting Load') }}</label>
                            </div>
                            <div class="flex items-center gap-1 pb-2">
                                <input wire:model.live="type_of_activities" name="radio-13" id="10"
                                    class="radio-xs peer/10 checked:bg-blue-500 radio" type="radio" name="10"
                                    value="Hazardous Substance" />
                                <label for="10"
                                    class="text-xs font-semibold peer-checked/10:text-blue-500">{{ __('Hazardous Substance') }}</label>
                            </div>
                            <div class="flex items-center gap-1 pb-2">
                                <input wire:model.live="type_of_activities" name="radio-13" id="11"
                                    class="radio-xs peer/11 checked:bg-purple-500 radio" type="radio"
                                    name="11" value="Fatigue Management" />
                                <label for="11"
                                    class="text-xs font-semibold peer-checked/11:text-purple-500">{{ __('Fatigue Management') }}</label>
                            </div>
                            <div class="flex items-center gap-1 pb-2">
                                <input wire:model.live="type_of_activities" name="radio-13" id="12"
                                    class="radio-xs peer/12 checked:bg-fuchsia-500 radio" type="radio"
                                    name="12" value="Work Permit" />
                                <label for="12"
                                    class="text-xs font-semibold peer-checked/12:text-fuchsia-500">{{ __('Work Permit') }}</label>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 pb-2">
                            <input wire:model.live="type_of_activities" name="radio-13" id="draft"
                                class="radio-xs peer/draft checked:bg-indigo-500 radio" type="radio" name="13"
                                value="Other activities" />
                            <label for="draft"
                                class="text-xs font-semibold peer-checked/draft:text-indigo-500">{{ __('Other activities') }}</label>
                            <div class="hidden w-full max-w-lg peer-checked/draft:block form-control">
                                <x-input wire:model.live='type_of_activities_other' :error="$errors->get('type_of_activities_other')" />
                                <x-label-error :messages="$errors->get('type_of_activities_other')" />
                            </div>
                        </div>
                    </fieldset>

                    <x-label-error :messages="$errors->get('type_of_activities')" />
                </div>
            </div>
            {{-- OBSERVERVATION CHECKLIST --}}
            <div role="tablist" class="mb-4 tabs tabs-lifted">
                <input type="radio" name="my_tabs_4" role="tab"
                    class="font-semibold tab font-signika text-rose-500 " aria-label="4.&ensp;Observation Checklist"
                    checked="checked" />
                <div role="tabpanel" class="p-2 tab-content bg-base-100 border-base-300 rounded-box ">
                    {{-- Abilities of the Team Performing Task --}}
                    <span
                        class="text-transparent divider divider-error bg-clip-text bg-gradient-to-r from-rose-500 to-orange-500">Abilities
                        of the Team Performing Task</span>
                    <div class="divide-x-2 shadow-md lg:grid lg:gap-1 lg:max-w-none lg:grid-cols-2">
                        <div class="overflow-x-auto">
                            <table class="table table-xs ">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Item</th>
                                        <th>Yes</th>
                                        <th>No</th>
                                        <th>N/A</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        class="text-center @error('step_of_the_task_in_correct_order') border-rose-500 border-2  @enderror">
                                        <th>1</th>
                                        <td class="text-left ">Step of the task in correct order</td>
                                        <td><input wire:model.live='step_of_the_task_in_correct_order' type="radio"
                                                value="yes" name="radio-1"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='step_of_the_task_in_correct_order' type="radio"
                                                value="no" name="radio-1"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='step_of_the_task_in_correct_order' type="radio"
                                                value="n/a" name="radio-1"
                                                class="radio radio-xs checked:bg-gray-500" /></td>

                                    </tr>
                                    <tr
                                        class="text-center @error('all_task_steps_are_followed') border-rose-500 border-2  @enderror">
                                        <th>2</th>
                                        <td class="text-left">All task steps are followed</td>
                                        <td><input wire:model.live='all_task_steps_are_followed' type="radio"
                                                name="radio-2" value="yes"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='all_task_steps_are_followed' type="radio"
                                                name="radio-2" value="no"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='all_task_steps_are_followed' type="radio"
                                                name="radio-2" value="n/a"
                                                class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>
                                    <tr
                                        class="text-center @error('worker_qualification') border-rose-500 border-2  @enderror">
                                        <th rowspan="3">3</th>

                                        <td class="text-left">a. &ensp; Worker Qualification (job title and level as pe
                                            JSEA)
                                        </td>

                                        <td><input wire:model.live='worker_qualification' type="radio"
                                                name="radio-3-a" value="yes"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='worker_qualification' type="radio"
                                                name="radio-3-a" value="no"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='worker_qualification' type="radio"
                                                name="radio-3-a" value="n/a"
                                                class="radio radio-xs checked:bg-gray-500" /></td>

                                    </tr>
                                    <tr class="@error('no_of_worker') border-rose-500 border-2  @enderror">
                                        <td>b. &ensp; No. of worker as per JSEA </td>
                                        <td class="text-center"><input wire:model.live='no_of_worker' type="radio"
                                                name="radio-3-b" value="yes"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td class="text-center"><input wire:model.live='no_of_worker' type="radio"
                                                name="radio-3-b" value="no"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td class="text-center"><input wire:model.live='no_of_worker' type="radio"
                                                name="radio-3-b" value="n/a"
                                                class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>
                                    <tr class="@error('appropriate_ppe') border-rose-500 border-2  @enderror">
                                        <td>c. &ensp; Appropriate PPE as per JSEA</td>
                                        <td class="text-center"><input wire:model.live='appropriate_ppe'
                                                type="radio" name="radio-3-c" value="yes"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td class="text-center"><input wire:model.live='appropriate_ppe'
                                                type="radio" name="radio-3-c" value="no"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td class="text-center"><input wire:model.live='appropriate_ppe'
                                                type="radio" name="radio-3-c" value="n/a"
                                                class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>
                                    <tr
                                        class="text-center @error('work_permit_completed') border-rose-500 border-2  @enderror">
                                        <th>4</th>
                                        <td class="text-left">Work permit completed</td>
                                        <td><input wire:model.live='work_permit_completed' value="yes"
                                                type="radio" name="radio-4"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='work_permit_completed' value="no"
                                                type="radio" name="radio-4"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='work_permit_completed' value="n/a"
                                                type="radio" name="radio-4"
                                                class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>
                                    <tr
                                        class="text-center @error('take5_completed') border-rose-500 border-2  @enderror">
                                        <th>5</th>
                                        <td class="text-left">TAKE 5 completed</td>
                                        <td><input wire:model.live='take5_completed' value="yes" type="radio"
                                                name="radio-5" class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='take5_completed' value="no" type="radio"
                                                name="radio-5" class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='take5_completed' value="n/a" type="radio"
                                                name="radio-5" class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>
                                    <tr
                                        class="text-center @error('pre_job_safety_talk_conductd_properly') border-rose-500 border-2  @enderror">
                                        <th>6</th>
                                        <td class="text-left">Pre-job safety talk conducted properly</td>
                                        <td><input wire:model.live='pre_job_safety_talk_conductd_properly'
                                                value="yes" type="radio" name="radio-6"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='pre_job_safety_talk_conductd_properly'
                                                value="no" type="radio" name="radio-6"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='pre_job_safety_talk_conductd_properly'
                                                value="n/a" type="radio" name="radio-6"
                                                class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>

                            </table>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="table text-center table-xs">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Item</th>
                                        <th>Yes</th>
                                        <th>No</th>
                                        <th>N/A</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th rowspan="3">7</th>
                                        <td class="text-left bg-slate-200" colspan="3">Equipment &amp; tools
                                            being
                                            used:
                                        </td>

                                    </tr>
                                    <tr class="@error('in_good_condition') border-rose-500 border-2  @enderror">
                                        <td class="text-left">a. &ensp; In good condition</td>
                                        <td><input wire:model.live='in_good_condition' value="yes" type="radio"
                                                name="radio-7-a" class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='in_good_condition' value="no" type="radio"
                                                name="radio-7-a" class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='in_good_condition' value="n/a" type="radio"
                                                name="radio-7-a" class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>
                                    <tr
                                        class="@error('used_properly_and_appropriately') border-rose-500 border-2  @enderror">
                                        <td class="text-left">b. &ensp; Used properly and appropriately</td>
                                        <td><input wire:model.live='used_properly_and_appropriately' value="yes"
                                                type="radio" name="radio-7-b"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='used_properly_and_appropriately' value="no"
                                                type="radio" name="radio-7-b"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='used_properly_and_appropriately' value="n/a"
                                                type="radio" name="radio-7-b"
                                                class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>
                                    <tr
                                        class="@error('communication_among_worker_properly') border-rose-500 border-2  @enderror">
                                        <th>8</th>
                                        <td class="text-left">Communication among worker properly</td>
                                        <td><input wire:model.live='communication_among_worker_properly'
                                                value="yes" type="radio" name="radio-8"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='communication_among_worker_properly'
                                                value="no" type="radio" name="radio-8"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='communication_among_worker_properly'
                                                value="n/a" type="radio" name="radio-8"
                                                class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>
                                    <tr class="@error('adequate_supervision') border-rose-500 border-2  @enderror">
                                        <th>9</th>
                                        <td class="text-left">Adequate Supervision</td>
                                        <td><input wire:model.live='adequate_supervision' value="yes"
                                                type="radio" name="radio-9"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='adequate_supervision' value="no"
                                                type="radio" name="radio-9"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='adequate_supervision' value="n/a"
                                                type="radio" name="radio-9"
                                                class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>
                                    <tr
                                        class="@error('sufficient_time_to_work_safely') border-rose-500 border-2  @enderror">
                                        <th>10</th>
                                        <td class="text-left">Sufficient time to work safely</td>
                                        <td><input wire:model.live='sufficient_time_to_work_safely' value="yes"
                                                type="radio" name="radio-10"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='sufficient_time_to_work_safely' value="no"
                                                type="radio" name="radio-10"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='sufficient_time_to_work_safely' value="n/a"
                                                type="radio" name="radio-10"
                                                class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>
                                    <tr
                                        class="@error('housekeeping_maintained_during_performing_the_task') border-rose-500 border-2  @enderror">
                                        <th>11</th>
                                        <td class="text-left">Housekeeping maintained during performing the task
                                        </td>
                                        <td><input wire:model.live='housekeeping_maintained_during_performing_the_task'
                                                value="yes" type="radio" name="radio-11"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='housekeeping_maintained_during_performing_the_task'
                                                value="no" type="radio" name="radio-11"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='housekeeping_maintained_during_performing_the_task'
                                                value="n/a" type="radio" name="radio-11"
                                                class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>
                                    <tr
                                        class="@error('job_conducted_safely_as_plan') border-rose-500 border-2  @enderror">
                                        <th>12</th>
                                        <td class="text-left">Job conducted safely as plan</td>
                                        <td><input wire:model.live='job_conducted_safely_as_plan' value="yes"
                                                type="radio" name="radio-12"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='job_conducted_safely_as_plan' value="no"
                                                type="radio" name="radio-12"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='job_conducted_safely_as_plan' value="n/a"
                                                type="radio" name="radio-12"
                                                class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>

                            </table>
                        </div>
                    </div>

                    {{-- JSEA or Work Instruction(WI) --}}
                    <span
                        class="text-transparent divider divider-error bg-clip-text bg-gradient-to-r from-rose-500 to-orange-500">Adequacy
                        of Work Guidance</span>
                    <div class="text-center bg-slate-200 font-signika "> JSEA or Work Instruction(SWI)</div>
                    <div class="divide-x-2 shadow-md lg:grid lg:gap-1 lg:max-w-none lg:grid-cols-2">
                        <div class="overflow-x-auto">
                            <table class="table table-xs ">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Item</th>
                                        <th>Yes</th>
                                        <th>No</th>
                                        <th>N/A</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        class="text-center @error('still_valid_not_expired_1') border-rose-500 border-2  @enderror">
                                        <th>1</th>
                                        <td class="text-left">Still Valid, Not Expired</td>
                                        <td><input wire:model.live='still_valid_not_expired_1' value="yes"
                                                type="radio" name="radio-1-2"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='still_valid_not_expired_1' value="no"
                                                type="radio" name="radio-1-2"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='still_valid_not_expired_1' value="n/a"
                                                type="radio" name="radio-1-2"
                                                class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>
                                    <tr
                                        class="text-center @error('steps_of_the_task_in_correct_order') border-rose-500 border-2  @enderror">
                                        <th>2</th>
                                        <td class="text-left">Steps of the task in correct order</td>
                                        <td><input wire:model.live='steps_of_the_task_in_correct_order' value="yes"
                                                type="radio" name="radio-2-2"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='steps_of_the_task_in_correct_order' value="no"
                                                type="radio" name="radio-2-2"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='steps_of_the_task_in_correct_order' value="n/a"
                                                type="radio" name="radio-2-2"
                                                class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>
                                    <tr
                                        class="text-center @error('all_hazards_identified') border-rose-500 border-2  @enderror">
                                        <th>3</th>
                                        <td class="text-left">All hazards identified</td>
                                        <td><input wire:model.live='all_hazards_identified' value="yes"
                                                type="radio" name="radio-3-2"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='all_hazards_identified' value="no"
                                                type="radio" name="radio-3-2"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='all_hazards_identified' value="n/a"
                                                type="radio" name="radio-3-2"
                                                class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>
                            </table>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="table text-center table-xs">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Item</th>
                                        <th>Yes</th>
                                        <th>No</th>
                                        <th>N/A</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr
                                        class=" @error('all_hazards_adequately_controlled') border-rose-500 border-2  @enderror">
                                        <th>4</th>
                                        <td class="text-left">All hazards adequately controlled</td>
                                        <td><input wire:model.live='all_hazards_adequately_controlled' value="yes"
                                                type="radio" name="radio-4-2"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='all_hazards_adequately_controlled' value="no"
                                                type="radio" name="radio-4-2"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='all_hazards_adequately_controlled' value="n/a"
                                                type="radio" name="radio-4-2"
                                                class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>
                                    <tr
                                        class=" @error('align_with_referred_sop_or_cop') border-rose-500 border-2  @enderror">
                                        <th>5</th>
                                        <td class="text-left">Align with referred SOP or COP</td>
                                        <td><input wire:model.live='align_with_referred_sop_or_cop' value="yes"
                                                type="radio" name="radio-5-2"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='align_with_referred_sop_or_cop' value="no"
                                                type="radio" name="radio-5-2"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='align_with_referred_sop_or_cop' value="n/a"
                                                type="radio" name="radio-5-2"
                                                class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>
                                    <tr
                                        class=" @error('any_other_effective_work_method') border-rose-500 border-2  @enderror">
                                        <th>6</th>
                                        <td class="text-left">Any other effective work method</td>
                                        <td><input wire:model.live='any_other_effective_work_method' value="yes"
                                                type="radio" name="radio-6-2"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='any_other_effective_work_method' value="no"
                                                type="radio" name="radio-6-2"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='any_other_effective_work_method' value="n/a"
                                                type="radio" name="radio-6-2"
                                                class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>
                            </table>
                        </div>
                    </div>
                    {{-- SOP or COP --}}
                    <div class="text-center bg-slate-200 font-signika "> Prosedur or COP</div>
                    <div class="divide-x-2 shadow-md lg:grid lg:gap-1 lg:max-w-none lg:grid-cols-2">
                        <div class="overflow-x-auto">
                            <table class="table table-xs ">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Item</th>
                                        <th>Yes</th>
                                        <th>No</th>
                                        <th>N/A</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        class="text-center @error('still_valid_not_expired_2') border-rose-500 border-2  @enderror">
                                        <th>1</th>
                                        <td class="text-left">Still valid, Not Expired</td>
                                        <td><input wire:model.live='still_valid_not_expired_2' value="yes"
                                                type="radio" name="radio-1-3"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='still_valid_not_expired_2' value="no"
                                                type="radio" name="radio-1-3"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='still_valid_not_expired_2' value="n/a"
                                                type="radio" name="radio-1-3"
                                                class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>
                                    <tr
                                        class="text-center @error('specific_and_controlled') border-rose-500 border-2  @enderror">
                                        <th>2</th>
                                        <td class="text-left">Specific and controlled</td>
                                        <td><input wire:model.live='specific_and_controlled' value="yes"
                                                type="radio" name="radio-2-3"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='specific_and_controlled' value="no"
                                                type="radio" name="radio-2-3"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='specific_and_controlled' value="n/a"
                                                type="radio" name="radio-2-3"
                                                class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>
                            </table>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="table text-center table-xs">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Item</th>
                                        <th>Yes</th>
                                        <th>No</th>
                                        <th>N/A</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        class="text-center @error('adequately_convered_the_jsea') border-rose-500 border-2  @enderror">
                                        <th>3</th>
                                        <td class="text-left">Adequately covered the JSEA</td>
                                        <td><input wire:model.live='adequately_convered_the_jsea' value="yes"
                                                type="radio" name="radio-3-3"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='adequately_convered_the_jsea' value="no"
                                                type="radio" name="radio-3-3"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='adequately_convered_the_jsea' value="n/a"
                                                type="radio" name="radio-3-3"
                                                class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>
                                    <tr
                                        class="text-center @error('still_appropriate_to_current_condition') border-rose-500 border-2  @enderror">
                                        <th>4</th>
                                        <td class="text-left">Still appropriate to current condition</td>
                                        <td><input wire:model.live='still_appropriate_to_current_condition'
                                                value="yes" type="radio" name="radio-4-3"
                                                class="radio radio-xs checked:bg-blue-500" /></td>
                                        <td><input wire:model.live='still_appropriate_to_current_condition'
                                                value="no" type="radio" name="radio-4-3"
                                                class="radio radio-xs checked:bg-rose-500" /></td>
                                        <td><input wire:model.live='still_appropriate_to_current_condition'
                                                value="n/a" type="radio" name="radio-4-3"
                                                class="radio radio-xs checked:bg-gray-500" /></td>
                                    </tr>
                            </table>
                        </div>
                    </div>
                    <div>
                        <div wire:ignore class="w-full form-control">
                            <x-label-req :value="__('Feedback for improvement')" />
                            <x-text-area id="feedback_for_improvement" wire:model.live='feedback_for_improvement'
                                :error="$errors->get('feedback_for_improvement')" />
                        </div>
                        <x-label-error :messages="$errors->get('feedback_for_improvement')" />
                    </div>

                </div>
            </div>

            {{-- DOCUMENTATION --}}
            <div role="tablist" class="mb-4 tabs tabs-lifted">
                <input type="radio" name="my_tabs_5" role="tab"
                    class="font-semibold tab font-signika text-rose-500 " aria-label="5.&ensp;Documentation"
                    checked="checked" />
                <div role="tabpanel" class="p-6 overflow-x-auto tab-content bg-base-100 border-base-300 rounded-box ">
                    <x-btn-add data-tip="Add data" wire:click="$dispatch('documentation_pto')" />

                    <livewire:event-report.pto-report.documentation.index :reference="$reference">
                </div>
            </div>
            {{-- DETAIL OF CORRECTIVE ACTIONS --}}
            <div role="tablist" class="mb-4 tabs tabs-lifted">
                <input type="radio" name="my_tabs_6" role="tab"
                    class="font-semibold tab font-signika text-rose-500 "
                    aria-label="6.&ensp;Detail Of Corrective Actions" checked="checked" />
                <div role="tabpanel" class="p-6 overflow-x-auto tab-content bg-base-100 border-base-300 rounded-box">
                    <x-btn-add data-tip="Add data" wire:click="$dispatch('openModalActionPTO')" />

                    <livewire:event-report.pto-report.action.index :reference="$reference">
                </div>
            </div>
            {{-- TABLE RISK ASSESSMENT --}}
            <div
                class="flex flex-col-reverse items-center mt-2 border-2 rounded-sm md:flex-row md:divide-x-2 divide-late-400/25 border-slate-400/25">

                <div class="flex-auto p-2 divide-y-2 divide-slate-400/25">
                    <div class="flex items-center">
                        <div class="flex-none px-2 w-52">
                            <div class="w-full max-w-md xl:max-w-xl form-control">
                                <x-label-req :value="__('Potential Consequence')" />

                                <x-select wire:model.live='risk_consequence_id' :error="$errors->get('risk_consequence_id')">
                                    <option value="">Select an option</option>
                                    @foreach ($RiskConsequence as $consequence)
                                        <option value="{{ $consequence->id }}">
                                            {{ $consequence->risk_consequence_name }}
                                        </option>
                                    @endforeach
                                </x-select>
                                <x-label-error :messages="$errors->get('risk_consequence_id')" />
                            </div>
                        </div>
                        <div class="w-full px-2">
                            <p class="text-justify ">
                                {{ $risk_consequence_doc }}
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-none px-2 w-52">
                            <div class="w-full max-w-md xl:max-w-xl form-control">
                                <x-label-req :value="__('Potential Likelihood')" />
                                <x-select wire:model.live='risk_likelihood_id' :error="$errors->get('risk_likelihood_id')">
                                    <option value="">Select an option</option>
                                    @foreach ($RiskLikelihood as $likelihood)
                                        <option value="{{ $likelihood->id }}">
                                            {{ $likelihood->risk_likelihoods_name }}
                                        </option>
                                    @endforeach
                                </x-select>
                                <x-label-error :messages="$errors->get('risk_likelihood_id')" />
                            </div>
                        </div>
                        <div class="px-2 ">
                            <p class="text-justify ">{{ $risk_likelihood_notes }}</p>
                        </div>
                    </div>

                </div>

                <div class="flex-none md:w-72 ">
                    <div class="m-1 overflow-x-auto">
                        <table class="table bg-base-300 table-xs">
                            <caption class="caption-top">
                                Table Initial Risk Assessment
                            </caption>
                            <thead>
                                <tr class="">
                                    <th colspan="2" class="p-0 text-center border-2 border-black">Legand</th>
                                    @foreach ($RiskAssessments as $risk_assessment)
                                        <td
                                            class="rotate_text text-start text-xs border-2 border-black   {{ $risk_assessment->colour }}">
                                            {{ $risk_assessment->risk_assessments_name }}

                                        </td>
                                    @endforeach
                                </tr>
                                <tr class="">
                                    <th class="text-center border-2 border-black">Likelihood</th>
                                    @foreach ($RiskConsequence as $risk_consequence)
                                        <th class="border-2 border-black rotate_text text-start">
                                            {{ $risk_consequence->risk_consequence_name }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($RiskLikelihood as $risk_likelihood)
                                    <tr>
                                        <th class=" p-0 text-[10px] font-semibold border-2 border-black">
                                            {{ $risk_likelihood->risk_likelihoods_name }}
                                        </th>
                                        @foreach ($risk_likelihood->RiskConsequence()->get() as $risk_consequence)
                                            <th class="p-0 text-xs font-semibold text-center border-2 border-black ">
                                                <label
                                                    wire:click="riskId({{ $risk_likelihood->id }}, {{ $risk_consequence->id }},{{ $TableRisk->where('risk_likelihood_id', $risk_likelihood->id)->where('risk_consequence_id', $risk_consequence->id)->first()->risk_assessment_id }})"
                                                    class="btn p-0 mt-1 btn-block btn-xs @if (
                                                        $tablerisk_id ==
                                                            $TableRisk->where('risk_likelihood_id', $risk_likelihood->id)->where('risk_consequence_id', $risk_consequence->id)->first()->id) border-4 border-neutral @endif {{ $TableRisk->where('risk_likelihood_id', $risk_likelihood->id)->where('risk_consequence_id', $risk_consequence->id)->first()->RiskAssessment->colour }}">
                                                </label>
                                            </th>
                                        @endforeach
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <table class="table table-xs">
                @foreach ($RiskAssessment as $item)
                    <tr>
                        <th class="w-40 text-xs border-2 border-slate-400">Potential Risk Rating</th>
                        <td class="pl-2 text-xs border-2 border-slate-400">
                            {{ $item->RiskAssessment->risk_assessments_name }}</td>
                    </tr>
                    <tr>
                        <th class="w-40 text-xs border-2 border-slate-400">Notify</th>
                        <td class="pl-2 text-xs border-2 border-slate-400">
                            {{ $item->RiskAssessment->reporting_obligation }}</td>
                    </tr>
                    <tr>
                        <th class="w-40 text-xs border-2 border-slate-400">Deadline</th>
                        <td class="pl-2 text-xs border-2 border-slate-400">{{ $item->RiskAssessment->notes }}</td>
                    </tr>
                    <tr>
                        <th class="w-40 text-xs border-2 border-slate-400">Coordinator</th>
                        <td class="pl-2 text-xs border-2 border-slate-400">
                            {{ $item->RiskAssessment->coordinator }}
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="modal-action ">
                <x-btn-save-active>{{ __('Submit') }} </x-btn-save-active>
            </div>
        </div>
    </form>
    <livewire:event-report.pto-report.observer-team.create :reference="$reference">
        <livewire:event-report.pto-report.action.create :reference="$reference">
            <livewire:event-report.pto-report.documentation.create :reference="$reference">
</div>
<script nonce="{{ csp_nonce() }}">
    // feedback_for_improvement
    ClassicEditor
        .create(document.querySelector('#feedback_for_improvement'), {
            toolbar: ['undo', 'redo', 'bold', 'italic', 'numberedList', 'bulletedList', 'link']

        })
        .then(newEditor => {
            newEditor.editing.view.change((writer) => {
                writer.setStyle(
                    "height", "155px", newEditor.editing.view.document.getRoot()
                );
            });
            newEditor.model.document.on('change:data', () => {
                @this.set('feedback_for_improvement', newEditor.getData())
            });
            window.addEventListener('articleStore', event => {
                newEditor.setData('');
            })
        })
        .catch(error => {
            console.error(error);
        });
</script>
