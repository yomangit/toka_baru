<div wire:target="store" wire:loading.class="skeleton">
    <div class="p-2">
        <div
            class="font-semibold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
                {{ $divider }}</span>
        </div>
        <form wire:submit.prevent='store'>
            @csrf
            @method('PATCH')
            <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                <x-label-req :value="__('Name')" />
                <x-select wire:model='name_company_id' :error="$errors->get('name_company_id')">
                    <option value="" selected>Select an option</option>
                    @foreach ($Company as $company)
                        <option value="{{ $company->id }}">
                            {{ $company->name_company }}</option>
                    @endforeach
                </x-select>
                <x-label-error :messages="$errors->get('name_company_id')" />
            </div>
            <div class="modal-action">
                <x-btn-save wire:target="store" wire:loading.class="btn-disabled">{{ __('Save') }}</x-btn-save>
                <x-btn-close wire:target="store" wire:loading.class="btn-disabled" wire:click="$dispatch('closeModal')"
                    >{{ __('Close') }}</x-btn-close>
            </div>
        </form>
    </div>
</div>
