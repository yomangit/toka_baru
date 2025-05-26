<div>
    <div wire:target="store" wire:loading.class="skeleton" class="p-2">
        <div
            class="py-4 font-extrabold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
            {{ $divider }} </div>
        <form wire:submit.prevent='store'>

            <table class="table table-xs">
                <thead>
                    <th>Step Properties</th>
                    <th>Step Transitions</th>
                </thead>
                <tbody>
                    <form wire:submit.prevent='store'>


                        <tr class="">
                            <td>
                                <div class="w-full max-w-md xl:max-w-xl form-control m-1">
                                    <div class=" sm:flex items-center">
                                        <x-label-req class=" w-32" :value="__('name')" />
                                        <x-input wire:model="name" :error="$errors->get('name')" />
                                    </div>
                                    <x-label-error :messages="$errors->get('name')" />
                                </div>
                                <div class="w-full max-w-md xl:max-w-xl form-control m-1">
                                    <div class=" sm:flex items-center">
                                        <x-label-req class=" w-32" :value="__('description_wf')" />
                                        <x-input wire:model="description" :error="$errors->get('description')" />
                                    </div>
                                    <x-label-error :messages="$errors->get('description')" />
                                </div>
                                <div class="w-full max-w-md xl:max-w-xl form-control m-1">
                                    <div class=" sm:flex items-center">
                                        <x-label-req class=" w-32" :value="__('status_code')" />
                                        <x-select wire:model="status_event_id" :error="$errors->get('status_event_id')">
                                            <option value="">Select an option</option>
                                            @foreach ($Status as $item)
                                                <option value="{{ $item->id }}">{{ $item->status_name }}
                                                </option>
                                            @endforeach

                                        </x-select>
                                    </div>
                                    <x-label-error :messages="$errors->get('status_event_id')" />
                                </div>
                                <div class="w-full max-w-md xl:max-w-xl form-control m-1">
                                    <div class=" sm:flex items-center">
                                        <x-label-req class=" w-32" :value="__('responsible_role')" />
                                        <x-select wire:model="responsible_role_id" :error="$errors->get('responsible_role_id')">
                                            <option value="">Select an option</option>
                                            @foreach ($ResponsibleRole as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->responsible_role_name }}
                                                </option>
                                            @endforeach

                                        </x-select>
                                    </div>
                                    <x-label-error :messages="$errors->get('responsible_role_id')" />
                                </div>
                                <div class="w-full max-w-md xl:max-w-xl form-control m-1">
                                    <div class=" sm:flex items-center">
                                        <x-label-req class=" w-32" :value="__('is_cancel_step')" />
                                        <fieldset
                                            class="flex items-start p-[3px]    @error('potential_lti') border-rose-500  @enderror gap-0.5">
                                            <input wire:model="is_cancel_step" name="radio-10" id="yes"
                                                class="radio-xs peer/yes checked:bg-rose-500 radio" type="radio"
                                                name="status" value="Cancel" />
                                            <label for="yes"
                                                class="text-xs font-semibold peer-checked/yes:text-rose-500">{{ __('Yes') }}</label>

                                            <input wire:model="is_cancel_step" name="radio-10" id="no"
                                                class="radio-xs peer/no checked:bg-sky-500 radio" type="radio"
                                                name="status" value="No" />
                                            <label for="no"
                                                class="text-xs font-semibold peer-checked/no:text-sky-500">{{ __('No') }}</label>

                                        </fieldset>
                                    </div>
                                    <x-label-error :messages="$errors->get('date')" />
                                </div>
                            </td>
                            <td class="">
                                <div class="w-full max-w-md xl:max-w-xl form-control m-1">
                                    <div class=" sm:flex items-center">
                                        <x-label-no-req class=" w-32" :value="__('Destination_1')" />
                                        <x-select wire:model="destination_1" :error="$errors->get('destination_1')">
                                            <option value="">Select an option</option>
                                            @foreach ($Workflowdetails as $item)
                                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <x-label-error :messages="$errors->get('destination_1')" />
                                </div>
                                <div class="w-full max-w-md xl:max-w-xl form-control m-1">
                                    <div class=" sm:flex items-center">
                                        <x-label-no-req class=" w-32" :value="__('destination_1_label')" />
                                        <x-input wire:model="destination_1_label" :error="$errors->get('destination_1_label')" />
                                    </div>
                                    <x-label-error :messages="$errors->get('destination_1_label')" />
                                </div>
                                <div class="w-full max-w-md xl:max-w-xl form-control m-1">
                                    <div class=" sm:flex items-center">
                                        <x-label-no-req class=" w-32" :value="__('Destination_2')" />
                                        <x-select wire:model="destination_2" :error="$errors->get('destination_2')">
                                            <option value="">Select an option</option>
                                            @foreach ($Workflowdetails as $item)
                                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <x-label-error :messages="$errors->get('destination_2')" />
                                </div>
                                <div class="w-full max-w-md xl:max-w-xl form-control m-1">
                                    <div class=" sm:flex items-center">
                                        <x-label-no-req class=" w-32" :value="__('destination_2_label')" />
                                        <x-input wire:model="destination_2_label" :error="$errors->get('destination_2_label')" />
                                    </div>
                                    <x-label-error :messages="$errors->get('destination_2_label')" />
                                </div>

                            </td>

                        </tr>
                </tbody>
            </table>
            <div class="modal-action">

                <x-btn-save wire:target="store" wire:loading.class="btn-disabled">{{ __('Save') }}</x-btn-save>
                <x-btn-close wire:target="store" wire:loading.class="btn-disabled" wire:click="$dispatch('closeModal')"
                    >{{ __('Close') }}</x-btn-close>

            </div>

            <form>
    </div>
</div>
