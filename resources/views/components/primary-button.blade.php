<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-xs btn-success btn-outline']) }}>
    {{ $slot }}
</button>
