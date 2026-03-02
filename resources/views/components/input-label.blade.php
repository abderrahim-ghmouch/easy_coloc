@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-xs uppercase tracking-wider text-slate-500 dark:text-primary/60 mb-2']) }}>
    {{ $value ?? $slot }}
</label>
