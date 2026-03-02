<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-red-500/10 border border-red-500/20 rounded-xl font-bold text-sm text-red-500 hover:bg-red-500 hover:text-white transition-all active:scale-95 focus:outline-none focus:ring-2 focus:ring-red-500/50']) }}>
    {{ $slot }}
</button>
