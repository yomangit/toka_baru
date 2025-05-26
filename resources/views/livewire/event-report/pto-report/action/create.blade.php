<div>
    <div class="modal {{ $modal }}" role="dialog">
        <div class="p-2 modal-box" wire:target='store' wire:loading.class="skeleton">
            <div
                class="font-semibold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
                {{ $divider }}
            </div>
            <form wire:submit.prevent='store'>
                <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                    <x-label-no-req :value="__('Action')" />
                    <x-text-area wire:model.blur='action' :error="$errors->get('action')" />
                    <x-label-error :messages="$errors->get('action')" />
                </div>
                <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                    <x-label-req :value="__('By Who')" />
                    <div class="dropdown dropdown-end">
                        <x-input-search-with-error placeholder="report by who?" wire:model.live='report_by'
                            :error="$errors->get('report_by')" class="cursor-pointer read-only:bg-gray-200 " :readonly="$report_id"
                            tabindex="0" role="button" />
                        <div tabindex="0"
                            class="dropdown-content card card-compact  bg-base-300 text-primary-content z-[1] w-full  p-2 shadow">
                            <div class="relative">
                                <div class="overflow-auto scroll-smooth focus:scroll-auto h-24 pt-2 mb-2"
                                    wire:target='report_by' wire:loading.class='hidden'>
                                    @forelse ($Report_by as $report)
                                        <div wire:click="reportByClick({{ $report->id }})"
                                            class="border-b border-base-200 flex flex-col cursor-pointer active:bg-gray-400">
                                            <strong
                                                class="text-[10px] text-slate-800">{{ $report->lookup_name }}</strong>
                                        </div>
                                    @empty
                                        <strong
                                            class="text-xs bg-clip-text text-transparent bg-gradient-to-r from-rose-400 to-rose-800">Name
                                            Not Found!!!</strong>
                                    @endforelse
                                </div>
                                <div class="hidden text-center pt-5" wire:target='report_by'
                                    wire:loading.class.remove='hidden'> <x-loading-spinner /></div>

                            </div>
                        </div>
                    </div>
                    <x-label-error :messages="$errors->get('report_by')" />
                </div>
                <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                    <x-label-req :value="__('Due Date')" />
                    <x-input-date id="due_date" wire:model.live='due_date' readonly :error="$errors->get('due_date')" />
                    <x-label-error :messages="$errors->get('due_date')" />
                </div>
                <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                    <x-label-req :value="__('Completion Date')" />
                    <x-input-date id="tanggal_komplite" wire:model.live='completion_date' readonly
                        :error="$errors->get('completion_date')" />
                    <x-label-error :messages="$errors->get('completion_date')" />
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
