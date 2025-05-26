<div>
    <div class="modal {{$modal}}">
            <div class="p-2 modal-box w-96" wire:target='store' wire:loading.class="skeleton">
                <div
                    class="font-semibold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
                    {{ $divider }}  {{$cek}}
                </div>
                <form wire:submit.prevent='store'>

                    @if ($manhours_id)
                        @method('PATCH')
                    @else
                        @csrf
                    @endif
                    <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                        <x-label-req :value="__('Date')" />
                        <x-input id="month" class="cursor-pointer" wire:model.live='date' readonly :error="$errors->get('date')" />
                        <x-label-error :messages="$errors->get('date')" />
                    </div>
                    <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                        <x-label-req :value="__('Company')" />
                        <x-select wire:model.live='company_id' :error="$errors->get('company_id')">
                            <option value="" selected>Select an option</option>
                            @foreach ($Company as $company)
                                <option value="{{ $company->id }}">
                                    {{ $company->name_company }}</option>
                            @endforeach
                        </x-select>
                        <x-label-error :messages="$errors->get('company_id')" />
                    </div>
                    <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                        <x-label-req :value="__('Department')" />
                        <x-select wire:model.live='dept_group_id' :error="$errors->get('dept_group_id')">
                            <option value="" selected>Select an option</option>
                            @foreach ($DeptGroup as $dept_group)
                                <option value="{{ $dept_group->id }}">
                                    {{ $dept_group->Dept->department_name }}</option>
                            @endforeach
                        </x-select>
                        <x-label-error :messages="$errors->get('dept_group_id')" />
                    </div>
                    <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                        <x-label-req :value="__('Job Class')" />
                        <x-select wire:model.live='job_class' :error="$errors->get('job_class')">
                            <option value="" selected>Select an option</option>
                            <option value="Supervisor" selected>Supervisor</option>
                            <option value="Operational" selected>Operational</option>
                            <option value="Administrator" selected>Administrator</option>

                        </x-select>
                        <x-label-error :messages="$errors->get('job_class')" />
                    </div>
                    <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                        <x-label-req :value="__('Manhours')" />
                        <x-input-type wire:model.blur='manhours' :type="$number" step="0.01"
                            placeholder='example 2032.12' :error="$errors->get('manhours')" />
                        <x-label-error :messages="$errors->get('manhours')" />
                    </div>
                    <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                        <x-label-req :value="__('Manpower')" />
                        <x-input-type wire:model.live='manpower' :type="$number" placeholder='example: 123'
                            :error="$errors->get('manpower')" />
                        <x-label-error :messages="$errors->get('manpower')" />
                    </div>
                    <div class="modal-action">
                        <x-btn-save wire:target="store"
                            wire:loading.class="btn-disabled">{{ __('Save') }}</x-btn-save>
                        <x-btn-close wire:click='closeModal' wire:target="store"
                            wire:loading.class="btn-disabled">{{ __('Close') }}</x-btn-close>
                    </div>
                </form>
            </div>
    </div>

</div>
