@props(['value', 'name', 'error'])
<textarea
    {{ $attributes->class([
        'textarea textarea-bordered textarea-xs resize-y px-3  border shadow-sm border-slate-300 placeholder-slate-400
                focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full  sm:text-sm font-semibold focus:ring-1 ',
        'border-rose-500 ring-1 ring-rose-500 textarea textarea-bordered textarea-xs  px-3  border shadow-sm border-slate-300 placeholder-slate-400' => $error,
    ]) }}
    @isset($name) name="{{ $name }}" @endif
    @isset($value) value="{{ $value }}" @endif
    {{ $attributes }}></textarea>
