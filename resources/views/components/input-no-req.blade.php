@props(['value', 'name', ])

<input
    {{ $attributes->class([
        'input input-bordered input-xs  px-3  border shadow-sm border-slate-300 placeholder-slate-400
            focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full  sm:text-sm font-semibold focus:ring-1 '
    ]) }}
    @isset($name) name="{{ $name }}" @endif
type="text"
@isset($value) value="{{ $value }}" @endif
    {{ $attributes }} />
