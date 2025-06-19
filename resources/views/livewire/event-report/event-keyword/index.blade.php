<div class="" wire:target="store_keyword" wire:loading.class="skeleton">
    <div class="w-full max-w-xs form-control">
        <label class="cursor-pointer label">
            <span class="label-text">{{__('Show Selected Only')}}</span>
            <input wire:model.live='show_checked' type="checkbox" class="checkbox [--chkbg:oklch(var(--a))] [--chkfg:oklch(var(--p))] checked:border-rose-500 checkbox-xs" />
        </label>
    </div>
    <form>
        @csrf
        <div>

            <ul class="menu menu-md bg-base-200 rounded-box " wire:target="store_keyword" wire:loading.class="skeleton">
                @foreach ($Keyword as $keyword)

                @if (count($keyword->children) == 0)
                <li>
                    <label class="label cursor-pointer">
                        <span class="label-text text-xs">{{ $keyword->name }}</span>
                        <input type="checkbox" wire:model.live='parent_id' value="{{ $keyword->id }}" {{ $current_step === 'Closed' || $current_step === 'Cancelled' ? 'disabled' : '' }} class="checkbox [--chkbg:theme(colors.indigo.600)] [--chkfg:orange] checked:border-indigo-800 checkbox-xs" />
                    </label>
                </li>
                @else

                <li>

                    <details @if (in_array($keyword->id,$key_id)) open @endif >

                        <summary>
                            {{ $keyword->name }}
                        </summary>
                        <ul>
                            @foreach ($keyword->children as $child)
                            @if (count($child->children) == 0)
                            <li wire:click='store_keyword'>
                                <label class="label cursor-pointer">
                                    <span class="label-text text-xs ">{{ $child->name }}</span>
                                    <input type="checkbox" wire:model.live='parent_id' value="{{ $child->name }}" {{ $current_step === 'Closed' || $current_step === 'Cancelled' ? 'disabled' : '' }} class="checkbox [--chkbg:theme(colors.indigo.600)] [--chkfg:orange] checked:border-indigo-800 checkbox-xs" />
                                </label>
                            </li>

                            @else

                            <li>

                                <details @if (in_array($child->id,$key_id)) open @endif >
                                    <summary>
                                        {{ $child->name }}
                                    </summary>
                                    <ul>
                                        @foreach ($child->children as $child2)
                                        @if (count($child2->children) == 0)
                                        <li wire:click='store_keyword'> <label class="label cursor-pointer">
                                                <span class="label-text text-xs">{{ $child2->name }}</span>
                                                <input type="checkbox" wire:model.live='parent_id' value="{{ $child2->name }}" {{ $current_step === 'Closed' || $current_step === 'Cancelled' ? 'disabled' : '' }} class="checkbox [--chkbg:theme(colors.indigo.600)] [--chkfg:orange] checked:border-indigo-800 checkbox-xs" />
                                            </label>
                                        </li>
                                        @else
                                        <li>
                                            <details @if (in_array($child2->id,$key_id)) open @endif >
                                                <summary>{{ $child2->name }}</summary>
                                                <ul>
                                                    @foreach ($child2->children as $child3)
                                                    @if (count($child3->children) == 0)
                                                    <li wire:click='store_keyword'>
                                                        <label class="label cursor-pointer">
                                                            <span class="label-text text-xs">{{ $child3->name }}</span>
                                                            <input type="checkbox" wire:model.live='parent_id' {{ $current_step === 'Closed' || $current_step === 'Cancelled' ? 'disabled' : '' }} value="{{ $child3->name }}" class="checkbox [--chkbg:theme(colors.indigo.600)] [--chkfg:orange] checked:border-indigo-800 checkbox-xs" />
                                                        </label>
                                                    </li>
                                                    @else
                                                    <li>
                                                        <details @if (in_array($child3->id,$key_id)) open @endif >
                                                            <summary>
                                                                {{ $child3->name }}
                                                            </summary>
                                                            <ul>
                                                                @foreach ($child3->children as $child4)
                                                                @if (count($child4->children) == 0)
                                                                <li wire:click='store_keyword'> <label class="label cursor-pointer">
                                                                        <span class="label-text text-xs">{{ $child4->name }}</span>
                                                                        <input type="checkbox" wire:model.live='parent_id' {{ $current_step === 'Closed' || $current_step === 'Cancelled' ? 'disabled' : '' }} value="{{ $child4->name }}" class="checkbox [--chkbg:theme(colors.indigo.600)] [--chkfg:orange] checked:border-indigo-800 checkbox-xs" />
                                                                    </label>
                                                                </li>
                                                                @else
                                                                <li>
                                                                    <details @if (in_array($child4->id,$key_id)) open @endif >
                                                                        <summary>
                                                                            {{ $child4->name }}
                                                                        </summary>
                                                                        <ul>
                                                                            @foreach ($child4->children as $child5)
                                                                            <li wire:click='store_keyword'>
                                                                                <label class="label cursor-pointer">
                                                                                    <span class="label-text text-xs">{{ $child5->name }}</span>
                                                                                    <input {{ $current_step === 'Closed' || $current_step === 'Cancelled' ? 'disabled' : '' }} type="checkbox" wire:model.live='parent_id' value="{{ $child5->name }}" class="checkbox [--chkbg:theme(colors.indigo.600)] [--chkfg:orange] checked:border-indigo-800 checkbox-xs" />
                                                                                </label>
                                                                            </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </details>
                                                                </li>
                                                                @endif
                                                                @endforeach
                                                            </ul>
                                                        </details>
                                                    </li>
                                                    @endif
                                                    @endforeach
                                                </ul>
                                            </details>
                                        </li>
                                        @endif
                                        @endforeach
                                    </ul>
                                </details>
                            </li>
                            @endif
                            @endforeach
                        </ul>
                    </details>
                </li>
                @endif
                @endforeach
            </ul>
            <x-label-error :messages="$errors->get('parent_id')" />

        </div>

    </form>
</div>
