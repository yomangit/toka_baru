<div>
    <label wire:click="openModal" class="btn btn-square btn-xs btn-outline btn-info tooltip tooltip-right tooltip-info"
        data-tip="Add Data">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
            <path fill-rule="evenodd"
                d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z"
                clip-rule="evenodd" />
        </svg>
    </label>
    <dialog class="{{ $modal }} ">
        <div class="modal-box">
            <div
                class="py-4 font-extrabold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
                {{ $divider }}</div>
            <form wire:submit.prevent='store'>
                @csrf
                @method('PATCH')
                <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                    <x-label-req :value="__('Division')" />
                    <x-select wire:model.live='division_id' :error="$errors->get('division_id')">
                        <option value="" selected>Select an option</option>
                        @foreach ($Division as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->DeptByBU->BusinesUnit->Company->name_company }}-{{  $item->DeptByBU->Department->department_name  }} @if(!empty($item->company_id))-{{ $item->Company->name_company }}@endif
                            </option>
                        @endforeach
                    </x-select>
                    <x-label-error :messages="$errors->get('division_id')" />
                </div>
               
                @if ($workgroup_id)
                    <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control ">
                        <x-label-req :value="__('Job Class')" />
                        <x-select wire:model='job_class_id_update' class="py-0 pl-2 pr-4" :error="$errors->get('job_class_id_update')">
                            <option value="" selected>Select an option</option>
                            @foreach ($JobClass as $job_class)
                                <option value="{{ $job_class->id }}">
                                    {{ $job_class->job_class_name }}</option>
                            @endforeach
                        </x-select>
                        <x-label-error :messages="$errors->get('job_class_id_update')" class="mt-0" />
                    </div>
                @else
                    <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control ">
                        <x-label-req :value="__('Job Class')" />
                        <div class="relative">
                            <x-select wire:model='job_class_id.0' class="py-0 pl-2 pr-4" :error="$errors->get('job_class_id.0')">
                                <option value="" selected>Select an option</option>
                                @foreach ($JobClass as $job_class)
                                    <option value="{{ $job_class->id }}">
                                        {{ $job_class->job_class_name }}</option>
                                @endforeach
                            </x-select>
                            <div class="absolute inset-y-0 right-0 flex item-center">
                                <label wire:click="add({{ $i }})"
                                    class="btn btn-square btn-xs btn-info "><svg xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 16 16" fill="currentColor" class="size-4">
                                        <path fill-rule="evenodd"
                                            d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm.75-10.25v2.5h2.5a.75.75 0 0 1 0 1.5h-2.5v2.5a.75.75 0 0 1-1.5 0v-2.5h-2.5a.75.75 0 0 1 0-1.5h2.5v-2.5a.75.75 0 0 1 1.5 0Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </label>
                            </div>
                        </div>
                        <x-label-error :messages="$errors->get('job_class_id.0')" class="mt-0" />
                    </div>
                    @foreach ($select as $key => $value)
                        <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control ">
                            <x-label-req :value="__('Job Class')" />
                            <div class="relative">
                                <x-select wire:model="job_class_id.{{ $value }}" class="py-0 pl-2 pr-4"
                                    :error="$errors->get('job_class_id.' . $value)">
                                    <option value="" selected>Select an option</option>
                                    @foreach ($JobClass as $job_class)
                                        <option value="{{ $job_class->id }}">
                                            {{ $job_class->job_class_name }}</option>
                                    @endforeach
                                </x-select>
                                <div class="absolute inset-y-0 right-0 flex items-end">
                                    <label wire:click="remove({{ $key }})"
                                        class="btn btn-square btn-xs btn-error ">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                            class="size-4">
                                            <path fill-rule="evenodd"
                                                d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm4-7a.75.75 0 0 0-.75-.75h-6.5a.75.75 0 0 0 0 1.5h6.5A.75.75 0 0 0 12 8Z"
                                                clip-rule="evenodd" />
                                        </svg>

                                    </label>
                                </div>
                            </div>
                            <x-label-error :messages="$errors->get('job_class_id.' . $key)" class="mt-0" />
                        </div>
                    @endforeach
                @endif

                <div class="modal-action">
                    <button type="submit" class="btn btn-xs btn-success btn-outline">Save</button>
                    <label wire:click='closeModal' class="btn btn-xs btn-error btn-outline">Close</label>
                </div>
            </form>
            <div>


            </div>
        </div>
    </dialog>
</div>
