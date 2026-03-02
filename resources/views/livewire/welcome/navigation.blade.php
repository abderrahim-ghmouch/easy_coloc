<nav class="flex items-center gap-4">
    @auth
        <a
            href="{{ url('/dashboard') }}"
            class="px-4 py-2 text-sm font-bold text-slate-300 hover:text-primary transition-colors"
        >
            Dashboard
        </a>
    @else
        <a
            href="{{ route('login') }}"
            class="px-4 py-2 text-sm font-bold text-slate-300 hover:text-primary transition-colors"
        >
            Log in
        </a>

        @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="px-5 py-2 text-sm font-bold bg-primary/10 text-primary border border-primary/20 rounded-lg hover:bg-primary/20 transition-all"
            >
                Register
            </a>
        @endif
    @endauth
</nav>
