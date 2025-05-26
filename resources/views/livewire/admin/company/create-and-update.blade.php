<div>
    <div class="p-2">
        <div
            class="font-semibold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
              {{$divider}}
        </div>
        <form wire:submit.prevent='store'>
            @csrf
            @method('PATCH')
            <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                <x-label-req :value="__('Name')" />
                <x-input wire:model.blur='name_company' :error="$errors->get('name_company')" />
                <x-label-error :messages="$errors->get('name_company')" />
            </div>
            <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                <x-label-req :value="__('Company Category')" />
                <x-select wire:model='company_category_id' :error="$errors->get('company_category_id')">
                    <option value="" selected>Select an option</option>
                    @foreach ($CompanyCategory as $company_category)
                        <option value="{{ $company_category->id }}">
                            {{ $company_category->name_category_company }}</option>
                    @endforeach
                </x-select>
                <x-label-error :messages="$errors->get('company_category_id')" class="mt-0" />
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
