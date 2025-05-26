@props(['value'])
<label class="p-0 mt-2 label">
    <span {{ $attributes->merge(['class' => 'block capitalize relative font-semibold label-text-alt']) }}>
        {{ $value ?? $slot }}<sup class="font-features font-bold sups text-[10px] text-rose-500">*</sup></span>
</label>
