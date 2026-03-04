<button {{ $attributes->merge(['type' => 'submit', 'class' => 'flex w-full items-center justify-center gap-2 rounded-xl bg-white px-8 py-4 text-[10px] font-black uppercase tracking-[0.2em] text-black transition-all hover:bg-neutral-200 active:scale-95 disabled:opacity-50 disabled:pointer-events-none']) }}>
    {{ $slot }}
</button>
