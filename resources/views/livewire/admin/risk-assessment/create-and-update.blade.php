<div>
    <div wire:target="store" wire:loading.class="skeleton" class="p-2">
        <div
            class="py-4 font-extrabold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
            {{ $divider }}</div>
            <form wire:submit.prevent='store'>
                @csrf
                @method('PATCH')
                <div class="h-80 overflow-y-auto px-4">
                    <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                        <x-label-req :value="__('Name')" />
                        <x-input wire:model.blur='risk_assessments_name' :error="$errors->get('risk_assessments_name')" />
                        <x-label-error :messages="$errors->get('risk_assessments_name')" />
                    </div>
                    <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                        <x-label-req :value="__('Notes')" />
                        <x-text-area wire:model.blur='notes' :error="$errors->get('notes')" />
                        <x-label-error :messages="$errors->get('notes')" />
                    </div>
                    <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                        <x-label-req :value="__('Action days')" />
                        <x-input wire:model.blur='action_days' :error="$errors->get('action_days')" />
                        <x-label-error :messages="$errors->get('action_days')" />
                    </div>
                    <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                        <x-label-req :value="__('Coordinator')" />
                        <x-input wire:model.blur='coordinator' :error="$errors->get('coordinator')" />
                        <x-label-error :messages="$errors->get('coordinator')" />
                    </div>
                    <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                        <x-label-req :value="__('Reporting obligation')" />
                        <x-input wire:model.blur='reporting_obligation' :error="$errors->get('reporting_obligation')" />
                        <x-label-error :messages="$errors->get('reporting_obligation')" />
                    </div>
                    <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                        <x-label-req :value="__('Colour')" />
                        <x-input wire:model.blur='colour' :error="$errors->get('colour')" />
                        <x-label-error :messages="$errors->get('colour')" />
                    </div>
                </div>
                <div class="modal-action">
                    <x-btn-save wire:target="store" wire:loading.class="btn-disabled">{{ __('Save') }}</x-btn-save>
                    <x-btn-close wire:target="store" wire:loading.class="btn-disabled" wire:click="$dispatch('closeModal')"
                        >{{ __('Close') }}</x-btn-close>
                </div>
            </form>
        </div>
</div>
