<div>
    <div class="divider divider-accent">Keyword Maintenance</div>
    <div class="grid grid-cols-2 gap-2 w-full">
        <div class="w-full max-w-md">
            <ul class="menu menu-md bg-base-200 rounded-box ">
                @foreach ($Keyword as $keyword)
                    @if (count($keyword->children) == 0)
                        <li>
                            <label class="label cursor-pointer">
                                <span class="label-text text-xs">{{ $keyword->name }}</span>
                                <input type="radio" wire:model.live='parent_id' value="{{ $keyword->id }}"
                                    name="radio-10" class="radio checked:bg-red-500 radio-xs" checked="checked" />
                            </label>
                        </li>
                    @else
                        <li>
                            <details>
                                <summary>
                                    <label class="label cursor-pointer gap-2">
                                        <span class="label-text text-xs">{{ $keyword->name }}</span>
                                        <input type="radio" wire:model.live='parent_id' value="{{ $keyword->id }}"
                                            name="radio-10" class="radio checked:bg-red-500 radio-xs"
                                            checked="checked" />
                                    </label>
                                </summary>
                                <ul>
                                    @foreach ($keyword->children as $child)
                                        @if (count($child->children) == 0)
                                            <li>
                                                <label class="label cursor-pointer">
                                                    <span class="label-text text-xs">{{ $child->name }}</span>
                                                    <input type="radio" wire:model.live='parent_id'
                                                        value="{{ $child->id }}" name="radio-10"
                                                        class="radio checked:bg-red-500 radio-xs" checked="checked" />
                                                </label>
                                            </li>
                                        @else
                                            <li>
                                                <details>
                                                    <summary>
                                                        <label class="label cursor-pointer gap-2">
                                                            <span class="label-text text-xs">{{ $child->name }}</span>
                                                            <input type="radio" wire:model.live='parent_id'
                                                                value="{{ $child->id }}" name="radio-10"
                                                                class="radio checked:bg-red-500 radio-xs"
                                                                checked="checked" />
                                                        </label>
                                                    </summary>
                                                    <ul>
                                                        @foreach ($child->children as $child2)
                                                            @if (count($child2->children) == 0)
                                                                <li> <label class="label cursor-pointer">
                                                                        <span
                                                                            class="label-text text-xs">{{ $child2->name }}</span>
                                                                        <input type="radio"
                                                                            wire:model.live='parent_id'
                                                                            value="{{ $child2->id }}" name="radio-10"
                                                                            class="radio checked:bg-red-500 radio-xs"
                                                                            checked="checked" />
                                                                    </label>
                                                                </li>
                                                            @else
                                                                <li>
                                                                    <details>
                                                                        <summary>{{ $child2->name }}</summary>
                                                                        <ul>
                                                                            @foreach ($child2->children as $child3)
                                                                                @if (count($child3->children) == 0)
                                                                                    <li>
                                                                                        <label
                                                                                            class="label cursor-pointer">
                                                                                            <span
                                                                                                class="label-text text-xs">{{ $child3->name }}</span>
                                                                                            <input type="radio"
                                                                                                wire:model.live='parent_id'
                                                                                                value="{{ $child3->id }}"
                                                                                                name="radio-10"
                                                                                                class="radio checked:bg-red-500 radio-xs"
                                                                                                checked="checked" />
                                                                                        </label>
                                                                                    </li>
                                                                                @else
                                                                                    <li>
                                                                                        <details>
                                                                                            <summary>
                                                                                                <label
                                                                                                    class="label cursor-pointer gap-2">
                                                                                                    <span
                                                                                                        class="label-text text-xs">{{ $child3->name }}</span>
                                                                                                    <input
                                                                                                        type="radio"
                                                                                                        wire:model.live='parent_id'
                                                                                                        value="{{ $child3->id }}"
                                                                                                        name="radio-10"
                                                                                                        class="radio checked:bg-red-500 radio-xs"
                                                                                                        checked="checked" />
                                                                                                </label>
                                                                                            </summary>
                                                                                            <ul>
                                                                                                @foreach ($child3->children as $child4)
                                                                                                    @if (count($child4->children) == 0)
                                                                                                        <li> <label
                                                                                                                class="label cursor-pointer">
                                                                                                                <span
                                                                                                                    class="label-text text-xs">{{ $child4->name }}</span>
                                                                                                                <input
                                                                                                                    type="radio"
                                                                                                                    wire:model.live='parent_id'
                                                                                                                    value="{{ $child4->id }}"
                                                                                                                    name="radio-10"
                                                                                                                    class="radio checked:bg-red-500 radio-xs"
                                                                                                                    checked="checked" />
                                                                                                            </label>
                                                                                                        </li>
                                                                                                    @else
                                                                                                        <li>
                                                                                                            <details>
                                                                                                                <summary>
                                                                                                                    {{ $child4->name }}
                                                                                                                </summary>
                                                                                                                <ul>
                                                                                                                    @foreach ($child4->children as $child5)
                                                                                                                        <li><a>{{ $child5->name }}</a>
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
        </div>

        <div class="card bg-base-100 w-full max-w-md shadow-xl h-24 ">
           
                <form wire:submit.prevent='store' class=px-2>
                    @csrf
                    @method('PATCH')
                    <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                        <x-label-req :value="__('Name')" />
                        <x-input wire:model.blur='name' :error="$errors->get('name')" />
                        <x-label-error :messages="$errors->get('name')" />
                    </div>
                    <div class="modal-action">
                        <x-btn-save wire:target="store"
                            wire:loading.class="btn-disabled">{{ __('Add') }}</x-btn-save>

                    </div>
                </form>
            
        </div>
    </div>
</div>
