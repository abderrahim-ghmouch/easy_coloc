@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500 mb-2']) }}>
    {{ $value ?? $slot }}
</label>
