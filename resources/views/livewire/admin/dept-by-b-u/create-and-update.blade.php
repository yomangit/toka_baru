<div>
    <div class="p-2" wire:target='store' wire:loading.class="skeleton">
        <div
            class="font-semibold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
                {{ $divider }}
        </div>
        <form wire:submit.prevent='store'>
            @csrf
            @method('PATCH')
            <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                <x-label-req :value="__('Business Unit')" />
                <x-select wire:model='busines_unit_id' :error="$errors->get('busines_unit_id')">
                    <option value="" selected>Select an option</option>
                    @foreach ($BusinesUnit as $bu)
                        <option value="{{ $bu->id }}">
                            {{ $bu->Company->name_company }}</option>
                    @endforeach
                </x-select>
                <x-label-error :messages="$errors->get('busines_unit_id')" />
            </div>
            <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                <x-label-req :value="__('Department')" />
                <x-select wire:model='department_id' :error="$errors->get('department_id')">
                    <option value="" selected>Select an option</option>
                    @foreach ($Department as $dept)
                        <option value="{{ $dept->id }}">
                            {{ $dept->department_name }}</option>
                    @endforeach
                </x-select>
                <x-label-error :messages="$errors->get('department_id')" class="mt-0" />
            </div>
            <div>

            </div>
            <div class="modal-action">
                <x-btn-save wire:target="store" wire:loading.class="btn-disabled">{{ __('Save') }}</x-btn-save>
                <x-btn-close wire:target="store" wire:loading.class="btn-disabled"
                    wire:click="$dispatch('closeModal')">{{ __('Close') }}</x-btn-close>
            </div>
        </form>
    </div>

</div>
