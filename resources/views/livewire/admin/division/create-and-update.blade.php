<div>
        <div wire:target="store" wire:loading.class="skeleton" class="p-2">
            <div class="font-semibold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
                    {{ $divider }} 
            </div>
            <form wire:submit.prevent='store' >
                @csrf
                @method('PATCH')
                <div class="w-full max-w-md xl:max-w-xl form-control">
                    <x-label-req :value="__('Business Unit')" />
                    <x-select wire:model.live='dept_by_business_unit_id' :error="$errors->get('dept_by_business_unit_id')">
                        <option value="" selected>Select an option</option>
                        @foreach ($DeptUnderBU as $item)
                        <option value="{{ $item->id }}">{{ $item->BusinesUnit->Company->name_company }}-{{ $item->Department->department_name }}</option>
                        @endforeach
                    </x-select>
                    <x-label-error :messages="$errors->get('dept_by_business_unit_id')" />
                </div>
                <div class="w-full max-w-md xl:max-w-xl form-control">
                    <x-label-no-req :value="__('Cotractor')" />
                    <x-select wire:model.live='company_id' :error="$errors->get('company_id')">
                        <option value="" selected>Select an option</option>
                        @foreach ($Company as $item)
                       <option value="{{ $item->id }}">{{ $item->name_company }}</option>
                        @endforeach
                    </x-select>
                    <x-label-error :messages="$errors->get('company_id')" />
                </div>
                <div class="w-full max-w-md xl:max-w-xl form-control">
                    <x-label-no-req :value="__('Section')" />
                    <x-select wire:model.live='section_id' :error="$errors->get('section_id')">
                        <option value="null" selected>Select an option</option>
                        @foreach ($Section as $item)
                       <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </x-select>
                    <x-label-error :messages="$errors->get('section_id')" />
                </div>
                <div class="modal-action">
                    <x-btn-save wire:target="store" wire:loading.class="btn-disabled">{{ __('Save') }}</x-btn-save>
                    <x-btn-close wire:target="store" wire:loading.class="btn-disabled"
                        wire:click="$dispatch('closeModal')">{{ __('Close') }}</x-btn-close>
                </div>
            </form>
        </div>
</div>
