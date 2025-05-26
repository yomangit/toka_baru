<div>
    <div class="modal {{ $modal }}" role="dialog">
        <div class="p-2 modal-box" wire:target='store' wire:loading.class="skeleton">
            <div
                class="font-semibold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
                {{$divider}}
            </div>
            <form wire:submit.prevent='store'>
                @csrf
                @method('PATCH')
                
                <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                    <x-label-req :value="__('Name')" />
                    <div class="dropdown dropdown-end">
                        <x-input-search-with-error placeholder="search name" wire:model.live='name_people'
                            :error="$errors->get('name_people')" class="cursor-pointer read-only:bg-gray-200 " tabindex="0"
                            role="button" />
                        <div tabindex="0"
                            class="dropdown-content card card-compact  bg-base-300 text-primary-content z-[1] w-full  p-2 shadow">
                            <div class="relative">
                                <ul class="overflow-auto scroll-smooth focus:scroll-auto h-28 pt-2 mb-2"
                                    wire:target='name_people' wire:loading.class='hidden'>
                                    @forelse ($Observer as $spv_area)
                                        <div wire:click="name_Click({{ $spv_area->id }})"
                                            class="border-b border-base-200 flex flex-col cursor-pointer active:bg-gray-400">
                                            <strong
                                                class="text-[10px] text-slate-800">{{ $spv_area->lookup_name }}</strong>
                                        </div>
                                    @empty
                                        <strong
                                            class="text-xs bg-clip-text text-transparent bg-gradient-to-r from-rose-400 to-rose-800">Name
                                            Not Found!!!</strong>
                                    @endforelse
                                    </ul>
                                <div class="hidden text-center pt-5" wire:target='name_people'
                                    wire:loading.class.remove='hidden'> <x-loading-spinner /></div>
                            </div>
                        </div>
                    </div>
                    <x-label-error :messages="$errors->get('supervisor_area')" />
                </div>
                <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                    <x-label-req :value="__('ID No')" />
                    <x-input wire:model.blur='id_card' :error="$errors->get('id_card')" />
                    <x-label-error :messages="$errors->get('id_card')" />
                </div>
                <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                    <x-label-req :value="__('Job Title')" />
                    <x-input wire:model.blur='job_title' :error="$errors->get('job_title')" />
                    <x-label-error :messages="$errors->get('job_title')" />
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
