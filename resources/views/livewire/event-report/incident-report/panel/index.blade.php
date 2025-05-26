<div>
    <form wire:submit.prevent='store'>
        @csrf
        @method('PATCH')
        <div wire:target="store" wire:loading.class="skeleton"
            class="p-2 my-1 text-xs border rounded-sm border-slate-300">
            <div class=" w-72">
                <div class="flex justify-between gap-x-1">
                    <div class="flex-none font-mono font-semibold w-28 ">
                        {{__('Current Step')}}
                    </div>
                    <div class="font-mono italic font-semibold grow">
                        {{ $current_step }}
                    </div>
                </div>
                <div class="flex justify-between gap-x-1">
                    <div class="flex-none font-mono font-semibold w-28 ">
                        Status
                    </div>
                    <div class="grow">
                        <span class="bg-clip-text font-semibold italic text-transparent {{ $bg_status }}">{{ $status
                            }}</span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-2 md:flex-row">
                @if($tampilkan)
                <div class="flex items-center gap-x-8">
                    <div class="flex-none font-mono font-semibold">
                        Procced To
                    </div>
                    <div class="grow gap-x-2">
                        <div class="w-auto">
                            <x-select wire:model.live='procced_to' :error="$errors->get('procced_to')">
                                <option value="">select an option</option>
                                @forelse ($Workflow as $value)
                                <option value="{{ $value->destination_1 }}">{{ $value->destination_1_label }}
                                </option>
                                @if ($value->destination_2)
                                <option value="{{ $value->destination_2 }}">{{ $value->destination_2_label }}
                                </option>
                                @elseif($value->is_cancel_step === 'Cancel')
                                <option value="{{ $value->is_cancel_step }}">{{ $value->is_cancel_step }}
                                </option>
                                @endif
                                @empty
                                @endforelse
                            </x-select>
                            <x-label-error :messages="$errors->get('procced_to')" />
                        </div>
                    </div>
                </div>
                @endif
              
                @if ($show)
                <div class="flex items-center gap-x-4">
                    <div class="flex-none font-mono font-semibold">
                        Assign To
                    </div>
                    <div class="grow gap-x-2">
                        <div class="w-full max-w-xs">
                            <x-select wire:model.live='assign_to' :error="$errors->get('assign_to')">
                                <option value="" selected>Select an option</option>
                                @foreach ($EventUserSecurity as $user)
                                <option value="{{ $user->user_id }}">{{ $user->User->lookup_name }}
                                </option>
                                @endforeach

                            </x-select>
                            <x-label-error :messages="$errors->get('assign_to')" />
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-x-4">
                    <div class="flex-none font-mono font-semibold">
                        Also Assign To
                    </div>
                    <div class="grow gap-x-2">
                        <div class="w-full max-w-xs">
                            <x-select wire:model.live='also_assign_to' :error="$errors->get('also_assign_to')">
                                <option value="" selected>Select an option</option>
                                @foreach ($EventUserSecurity as $user)
                                <option value="{{ $user->user_id }}">{{ $user->User->lookup_name }}
                                </option>
                                @endforeach
                            </x-select>
                            <x-label-error :messages="$errors->get('also_assign_to')" />
                        </div>
                    </div>
                </div>
                @endif
                <div class="flex items-center ">
                    @if($tampilkan)
                    <x-btn-panel  data-tip="submit"/>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>
