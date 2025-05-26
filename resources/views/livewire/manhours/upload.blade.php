<div>
    <div class="p-2" wire:target='files,store' wire:loading.class="skeleton">
        <div
            class="font-semibold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
                Upload File
        </div>
        <form wire:submit.prevent='store'>
            @csrf
            <div class="w-full max-w-md xl:max-w-xl form-control">
                <x-label-req :value="__('import_file')" />
                <x-input-file wire:model.live='files' :error="$errors->get('files')" />
                <x-label-error :messages="$errors->get('files')" />
            </div>
            <div class="modal-action">
                <x-btn-save wire:target="store,files" wire:loading.class="btn-disabled">{{ __('Save') }}</x-btn-save>
                <x-btn-close wire:target="store,files" wire:loading.class="btn-disabled"
                    wire:click="$dispatch('closeModal')">{{ __('Close') }}</x-btn-close>
            </div>
        </form>
    </div>
</div>
