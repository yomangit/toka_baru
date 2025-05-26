<div>
    <div class="p-2">
        <div
            class="font-semibold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500 p-0 m-0">

            {{ $divider }}
        </div>
        <form class="h-60 relative" wire:submit.prevent='store'>
            @csrf
            @method('PATCH')
            <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                <x-label-req :value="__('Name')" />
                <div class="dropdown dropdown-end">
                    <x-input wire:model.live='user_name' :error="$errors->get('user_name')" class="cursor-pointer" readonly tabindex="0"
                        role="button" />
                    <div tabindex="0"
                        class="dropdown-content card card-compact  bg-base-300 text-primary-content z-[1] w-full  p-2 shadow">
                        <div class="relative">
                            <div class="fixed top-0 left-0 right-0  bg-base-300 opacity-95 shadow-md">
                                <x-inputsearch name='search_people' wire:model.live='search_people'
                                    placeholder="{{ __('search_people') }}" />
                            </div>
                            <div class="overflow-auto scroll-smooth focus:scroll-auto h-28 pt-5 mb-2"
                                wire:target='search_people' wire:loading.class='hidden'>
                                @forelse ($User as $users)
                                    <div wire:click="user_input({{ $users->id }})"
                                        class="border-b border-base-200 flex flex-col cursor-pointer ">
                                        <strong class="text-[10px] text-slate-800">{{ $users->lookup_name }}</strong>
                                    </div>
                                @empty
                                    <strong
                                        class="text-xs bg-clip-text text-transparent bg-gradient-to-r from-rose-400 to-rose-800">Name
                                        Not Found!!!</strong>
                                @endforelse
                            </div>
                            <div class="hidden text-center pt-5" wire:target='search_people'
                                wire:loading.class.remove='hidden'> <x-loading-spinner /></div>
                            <div class="pb-6">{{ $User->links('pagination.minipaginate') }}</div>
                          
                        </div>
                    </div>
                </div>
                <x-label-error :messages="$errors->get('user_name')" />
            </div>
            <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                <x-label-req :value="__('Company ')" />
                <x-select wire:model='company_id' :error="$errors->get('company_id')">
                    <option value="" selected>Select an option</option>
                    @foreach ($Company as $companies)
                        <option value="{{ $companies->id }}">
                            {{ $companies->name_company }}</option>
                    @endforeach
                </x-select>
                <x-label-error :messages="$errors->get('company_id')" class="mt-0" />
            </div>
          
            <div class="modal-action absolute  bottom-0 right-0 ">
                <x-btn-save wire:target="store" wire:loading.class="btn-disabled">{{ __('Save') }}</x-btn-save>
                <x-btn-close wire:target="store" wire:loading.class="btn-disabled"
                    wire:click="$dispatch('closeModal')">{{ __('Close') }}</x-btn-close>
            </div>
        </form>
    </div>
</div>
