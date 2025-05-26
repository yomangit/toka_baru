@props(['value', 'name','error','step'])


<label class="relative block w-full ">
    <span class="sr-only">Search</span>
    <span class="absolute inset-y-0 left-0 flex items-center pl-2">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
            <path fill-rule="evenodd"
                d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z"
                clip-rule="evenodd" />
        </svg>

    </span>
    <input
        {{ $attributes->class([
            'input input-bordered input-xs font-sans font-semibold placeholder:italic placeholder:text-slate-400  w-full border border-slate-300 pl-6 pr-3 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-sm',
            'border-rose-500 ring-1 ring-rose-500 input input-bordered input-xs  px-3  border shadow-sm border-rose-500 placeholder-rose-500' => $error,
        ]) }}
        type="text" name="search"
        @isset($name) name="{{ $name }}" @endif
        @isset($step) disabled @endif 
        type="text"
        @isset($value) value="{{ $value }}" @endif
        {{ $attributes }} autocomplete="off"/>
</label>