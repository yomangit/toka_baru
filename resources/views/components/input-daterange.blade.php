@props(['value', 'name'])


<label class="relative block w-full max-w-xs">
    <span class="sr-only">Search</span>
    <span class="absolute inset-y-0 left-0 flex items-center pl-2">

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
            <path d="M5.75 7.5a.75.75 0 1 0 0 1.5.75.75 0 0 0 0-1.5ZM7.25 8.25A.75.75 0 0 1 8 7.5h2.25a.75.75 0 0 1 0 1.5H8a.75.75 0 0 1-.75-.75ZM5.75 9.5a.75.75 0 0 0 0 1.5H8a.75.75 0 0 0 0-1.5H5.75Z" />
            <path fill-rule="evenodd" d="M4.75 1a.75.75 0 0 0-.75.75V3a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2V1.75a.75.75 0 0 0-1.5 0V3h-5V1.75A.75.75 0 0 0 4.75 1ZM3.5 7a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v4.5a1 1 0 0 1-1 1h-7a1 1 0 0 1-1-1V7Z" clip-rule="evenodd" />
          </svg>
          

    </span>
    <input
        {{ $attributes->class([
            'input input-bordered input-xs font-sans font-semibold placeholder:italic placeholder:text-slate-400 block w-full border border-slate-300 pl-6 pr-3 shadow-sm focus:outline-none focus:border-sky-500 focus:ring-sky-500 focus:ring-1 sm:text-xs',
        ]) }}
        type="text" name="search"
        @isset($name) name="{{ $name }}" @endif
        type="text"
        @isset($value) value="{{ $value }}" @endif
        {{ $attributes }} autocomplete="off"/>
</label>
