<div>
    <div class="modal {{ $modal }}" role="dialog">
        <div class="p-2 modal-box" wire:target='store' wire:loading.class="skeleton">
            <div
                class="font-semibold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
                {{ $divider }}
            </div>
            <form wire:submit.prevent='store'>
                <div class=" overflow-y-auto p-1">
                    @csrf
                    @method('PATCH')
                    <div class="grid grid-cols-2 gap-x-2">
                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('first_name')" />
                            <x-input wire:model.live='first_name' :error="$errors->get('first_name')" />
                            <x-label-error :messages="$errors->get('first_name')" />
                        </div>
                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('last_name')" />
                            <x-input wire:model.live='last_name' :error="$errors->get('last_name')" />
                            <x-label-error :messages="$errors->get('last_name')" />
                        </div>

                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('lookup_name')" />
                            <x-input wire:model.live='lookup_name' readonly :error="$errors->get('lookup_name')" />
                            <x-label-error :messages="$errors->get('lookup_name')" />
                        </div>
                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-no-req :value="__('username')" />
                            <x-input wire:model.blur='username' :error="$errors->get('username')" />
                            <x-label-error :messages="$errors->get('username')" />
                        </div>
                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('Email')" />
                            <x-input-email wire:model.blur='email' :error="$errors->get('email')" />
                            <x-label-error :messages="$errors->get('email')" />
                        </div>
                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('employer')" />
                            <x-select wire:model.live='company_id' :error="$errors->get('company_id')">
                                <option value="" selected>Select an option</option>
                                @foreach ($Company as $company)
                                    <option value="{{ $company->id }}" selected>{{ $company->name_company }}</option>
                                @endforeach
                            </x-select>
                            <x-label-error :messages="$errors->get('company_id')" />
                        </div>
                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('Department')" />
                            <x-select wire:model.live='dept_id' :error="$errors->get('dept_id')">
                                <option value="" selected>Select an option</option>
                                @foreach ($Department as $dept)
                                    <option value="{{ $dept->id }}" selected>{{ $dept->department_name }}</option>
                                @endforeach
                            </x-select>
                            <x-label-error :messages="$errors->get('dept_id')" />
                        </div>

                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('employee_id')" />
                            <x-input wire:model.live='employee_id' :error="$errors->get('employee_id')" />
                            <x-label-error :messages="$errors->get('employee_id')" />
                        </div>
                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('gender')" />
                            <x-select wire:model.live='gender' :error="$errors->get('gender')">
                                <option value="" selected>Select an option</option>
                                <option value="Male" selected>Male</option>
                                <option value="Female" selected>Female</option>
                            </x-select>
                            <x-label-error :messages="$errors->get('gender')" />
                        </div>
                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('date_birth')" />
                            <x-input wire:model.live='date_birth' id="date_birth" readonly :error="$errors->get('date_birth')" />
                            <x-label-error :messages="$errors->get('date_birth')" />
                        </div>
                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('date_commenced')" />
                            <x-input wire:model.live='date_commenced' id="date_commenced" readonly :error="$errors->get('date_commenced')" />
                            <x-label-error :messages="$errors->get('date_commenced')" />
                        </div>
                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('end date of employment')" />
                            <x-input wire:model.live='end_date' id="end_date" readonly :error="$errors->get('end_date')" />
                            <x-label-error :messages="$errors->get('end_date')" />
                        </div>

                        <div class="w-full max-w-md xl:max-w-xl form-control">
                            <x-label-req :value="__('user_permit')" />
                            <x-select wire:model.live='role_user_permit_id' :error="$errors->get('role_user_permit_id')">
                                <option value="" selected>Select an option</option>
                                @foreach ($Role as $item)
                                    <option value="{{ $item->id }}" selected>{{ $item->name_role_user }}</option>
                                @endforeach

                            </x-select>
                            <x-label-error :messages="$errors->get('role_user_permit_id')" />
                        </div>
                    </div>
                </div>
                <div class="modal-action">
                    <x-btn-save wire:target="store" wire:loading.class="btn-disabled">{{ __('Save') }}</x-btn-save>
                <x-btn-close wire:target="store" wire:loading.class="btn-disabled"
                    wire:click="closeModal">{{ __('Close') }}</x-btn-close>
                </div>
            </form>
        </div>
    </div>
</div>
