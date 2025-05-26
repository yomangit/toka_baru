<div>
    <div wire:target="store" wire:loading.class="skeleton" class="p-2">
        <div
            class="py-4 font-extrabold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
            {{ $divider }}</div>
        <form wire:submit.prevent='store'>
            @csrf
            @if ($data_id)
                @method('PATCH')
            @endif
            <div class="w-full max-w-md xl:max-w-xl form-control">
                <x-label-req :value="__('Type of Involvement')" />
                <x-select wire:model.live='type_involvement_id'
                    class="{{ $current_step === 'Closed' || $current_step === 'Cancelled' ? 'btn-disabled bg-gray-300' : '' }}"
                    :error="$errors->get('type_involvement_id')">
                    <option value="" disabled selected>Select an option</option>
                    @foreach ($TypeInvolvement as $key => $value)
                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                    @endforeach
                </x-select>
                <x-label-error :messages="$errors->get('type_involvement_id')" />
            </div>

            <div class="w-full max-w-md xl:max-w-xl form-control">
                <x-label-req :value="__('employees involved')" />
                <x-input wire:model.live='people_name' :error="$errors->get('people_name')" placeholder="{{ __('Search Employee...') }}"
                    class=" text-[9px] {{ $current_step === 'Closed' || $current_step === 'Cancelled' ? 'btn-disabled bg-gray-300' : '' }}" />

                <div class="h-32 overflow-x-auto">
                    <table class="table table-xs">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Company</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($User as $index => $item)
                                <tr class="text-center cursor-pointer hover:bg-slate-200"
                                    wire:click="people_selected({{ $item->id }},'{{ $item->lookup_name }}')"
                                    wire:target='people_name' wire:loading.class='hidden'>
                                    <td>{{ $item->lookup_name }}</td>
                                    <td>{{ $item->company_id ? $item->company->name_company : '' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <th colspan="2" class="text-center" wire:target='people_name'
                                        wire:loading.class='hidden'>
                                        <span
                                            class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
                                            employee name was not found
                                        </span>
                                    </th>
                                </tr>
                            @endforelse
                            <tr class="hidden" wire:target='people_name' wire:loading.class.remove='hidden'>
                                <th colspan="2" class="text-center ">
                                    <x-loading-spinner />
                                </th>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <x-label-error :messages="$errors->get('people_name')" />
            </div>
            <div class="modal-action">
              <x-btn-save wire:target="store" wire:loading.class="btn-disabled">{{ __('Save') }}</x-btn-save>
              <x-btn-close wire:target="store" wire:loading.class="btn-disabled" wire:click="$dispatch('closeModal')"
                  >{{ __('Close') }}</x-btn-close>
            </div>
        </form>
    </div>
</div>
