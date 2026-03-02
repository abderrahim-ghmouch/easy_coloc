<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-6 py-3 bg-white/5 border border-primary/20 rounded-xl font-bold text-sm text-slate-400 hover:bg-white/10 hover:text-white transition-all active:scale-95 focus:outline-none focus:ring-2 focus:ring-primary/20']) }}>
    {{ $slot }}
</button>
