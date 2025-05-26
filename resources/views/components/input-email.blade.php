@props(['value', 'name', 'error'])

<input
    {{ $attributes->class([
        'file-input file-input-info file-input-bordered file-input-xs  pr-3  border shadow-sm border-slate-300 placeholder-slate-400
            focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full  sm:text-sm font-semibold focus:ring-1 ',
        'border-rose-500 ring-1 ring-rose-500 file-input file-input-bordered file-input-xs  pr-3  border shadow-sm border-slate-300 placeholder-slate-400' => $error,
    ]) }}
    @isset($name) name="{{ $name }}" @endif
type="mail"
@isset($value) value="{{ $value }}" @endif
    {{ $attributes }} />