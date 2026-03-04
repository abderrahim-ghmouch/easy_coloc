@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-[10px] font-bold text-red-500 uppercase tracking-widest mt-2 space-y-1']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
