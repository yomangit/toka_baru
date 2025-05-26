@props(['values', 'name', 'error'])

<input
    {{ $attributes->class([
        'checkbox-xs checkbox border-orange-400 [--chkbg:theme(colors.indigo.600)] [--chkfg:orange] checked:border-indigo-800',
    ]) }}
    @isset($name) name="{{ $name }}" @endif
    type="checkbox"
    @isset($values) value="{{ $values }}" @endif
    {{ $attributes }} />
