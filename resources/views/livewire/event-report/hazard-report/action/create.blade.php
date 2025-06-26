<div>
    <div class="modal {{ $modal }} " role="dialog">
        <div wire:target="store" wire:loading.class="skeleton" class="modal-box">
            <div
                class="py-2 font-extrabold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
                {{ $divider }}</div>
            <form wire:submit.prevent='store'>
                @csrf
                @method('PATCH')

                <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                    <x-label-req :value="__('Followup Action')" />
                    <x-text-area wire:model.blur='followup_action' :error="$errors->get('followup_action')" />
                    <x-label-error :messages="$errors->get('followup_action')" />
                </div>

                <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                    <x-label-no-req :value="__('Actionee Comment')" />
                    <x-text-area wire:model.blur='actionee_comment' :error="$errors->get('actionee_comment')" />
                    <x-label-error :messages="$errors->get('actionee_comment')" />
                </div>
                <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                    <x-label-no-req :value="__('Action Condition')" />
                    <x-text-area wire:model.blur='action_condition' :error="$errors->get('action_condition')" />
                    <x-label-error :messages="$errors->get('action_condition')" />
                </div>
                <!-- Name -->
                    <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                        <x-label-no-req  for="name" :value="__('Responsibility')" />
                        <div class="dropdown dropdown-end">
                            <x-input-search-with-error placeholder="search name" wire:model.live='responsibility_name'
                                :error="$errors->get('responsibility_name')" class="cursor-pointer read-only:bg-gray-200 " tabindex="0"
                                role="button" />
                            <div tabindex="0"
                                class="dropdown-content card card-compact  bg-base-300 text-primary-content z-[1] w-full  p-2 shadow">
                                <div class="relative">
                                    <ul class="overflow-auto scroll-smooth focus:scroll-auto h-28 pt-2 mb-2"
                                        wire:target='responsibility_name' wire:loading.class='hidden'>
                                        @forelse ($Report_By as $spv_area)
                                            <div wire:click="reportedBy({{ $spv_area->id }})"
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
                                    <div class="hidden text-center pt-5" wire:target='name'
                                        wire:loading.class.remove='hidden'> <x-loading-spinner /></div>
                                </div>
                            </div>
                        </div>
                        <x-label-error :messages="$errors->get('responsibility_name')" />
                    </div>
                <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                    <x-label-no-req :value="__('Due Date')" />
                    <x-input-date id="due_date" wire:model.live='due_date' readonly :error="$errors->get('due_date')" />
                    <x-label-error :messages="$errors->get('due_date')" />
                </div>
                <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                    <x-label-no-req :value="__('Completion Date')" />
                    <x-input-date id="completion_date" wire:model.live='completion_date' readonly :error="$errors->get('completion_date')" />
                    <x-label-error :messages="$errors->get('completion_date')" />
                </div>
                <div class="modal-action">
                    <x-btn-save>{{ __('Save') }}</x-btn-save>
                    <x-btn-close wire:click='closeModal'>{{ __('Close') }}</x-btn-close>
                </div>
            </form>
        </div>
    </div>


</div>
