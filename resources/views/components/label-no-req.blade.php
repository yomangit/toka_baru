@props(['value'])
<label class="p-0 mt-2 label">
    <span {{ $attributes->merge(['class' => 'block capitalize relative font-semibold label-text-alt']) }}>
        {{ $value ?? $slot }}</span>
</label>