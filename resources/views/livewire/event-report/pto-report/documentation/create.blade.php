<div>
    <div class="modal {{ $modal }}" role="dialog">
    <div wire:target="store,file_doc" wire:loading.class="skeleton" class="p-2 modal-box">
        <div
            class="py-4 font-extrabold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
           Documentation</div>
        <form wire:submit.prevent='store'>
            @csrf
            @method('PATCH')
            <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                <x-label-req :value="__('Description')" />
                <x-text-area wire:model.blur='description' :error="$errors->get('description')" />
                <x-label-error :messages="$errors->get('description')" />
            </div>
            <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                <x-label-req :value="__('File')" />
                <div class="relative ">
                    <x-input-file wire:model.blur='file_doc' :error="$errors->get('file_doc')" />
                    <span wire:target="file_doc"
                        wire:loading.class="loading-md loading loading-spinner text-accent absolute inset-y-0 right-0"></span>
                </div>
                <x-label-error :messages="$errors->get('file_doc')" />
            </div>
            <div class="modal-action">
                <x-btn-save wire:target="store" wire:loading.class="btn-disabled">{{ __('Save') }}</x-btn-save>
                    <x-btn-close wire:target="store" wire:loading.class="btn-disabled"
                    wire:click="closeModal">{{ __('Close') }}</x-btn-close>
            </div>
        </form>
    </div>
</div>
