@props(['disabled' => false])
@props(['error'])
<input {{ $disabled ? 'disabled' : '' }} 
@if ($error)
{!! $attributes->merge([
    'class' =>
        'border-rose-500 ring-1 ring-rose-500 input input-bordered input-xs  px-3  border shadow-sm border-rose-500 focus:outline-none placeholder-rose-500 focus:ring-1 ',
]) !!}
@else
{!! $attributes->merge([
    'class' =>
        'input input-bordered input-xs px-3 border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full  sm:text-xs font-semibold focus:ring-1 ',
]) !!}
@endif
>
