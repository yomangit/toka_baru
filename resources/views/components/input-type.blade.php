@props(['values', 'name', 'error', 'type'])

<input
    {{ $attributes->class([
        'input input-bordered input-xs  px-3  border shadow-sm border-slate-300 placeholder-slate-400
                focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full  sm:text-sm font-semibold focus:ring-1 ',
        'border-rose-500 ring-1 ring-rose-500 input input-bordered input-xs  px-3  border shadow-sm border-rose-500 placeholder-rose-500' => $error,
    ]) }}
    @isset($name) name="{{ $name }}" @endif
    @isset($type) type="{{ $type }}" @endif
    @isset($values) value="{{ $values }}" @endif
    {{ $attributes }} />
