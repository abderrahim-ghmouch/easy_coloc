<header class="sticky top-0 z-50 w-full border-b border-border-dark bg-background-dark/80 backdrop-blur-md">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-black font-display font-black text-xl shadow-lg shadow-white/10 transition-transform group-hover:scale-95">
                E
            </div>
            <h2 class="text-xl font-display font-bold tracking-tight text-white group-hover:opacity-80 transition-opacity">
                Easy<span class="text-neutral-500">Coloc</span>
            </h2>
        </a>

        @php
            function isActive($name)
            {
                $activeClass = 'text-white border-b-2 border-white pb-1';
                $inactiveClass = 'text-neutral-400 hover:text-white transition-all pb-1';
                return request()->routeIs($name) ? $activeClass : $inactiveClass;
            }
        @endphp

        <nav class="hidden md:flex items-center gap-10 font-display text-[13px] font-semibold uppercase tracking-widest">
            <a class="{{ isActive('home') }}" href="{{ route('home') }}">Home</a>
            <a class="{{ isActive('dashboard') }}" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="{{ isActive('colocation.index') }}" href="{{ route('colocation.index') }}">Colocations</a>
            @auth
                @if (auth()->user()->role == 'ADMIN')
                    <a class="{{ isActive('admin.index') }}" href="{{ route('admin.index') }}">Admin</a>
                @endif
            @endauth
        </nav>

        <div class="flex items-center gap-4">
            @guest
                <a href="{{ route('login') }}"
                    class="hidden sm:block text-xs font-bold text-neutral-500 hover:text-white uppercase tracking-widest transition-colors px-4">
                    Sign In
                </a>
                <a href="{{ route('register') }}"
                    class="btn-modern px-6 py-2.5 text-[10px] font-black uppercase tracking-widest">
                    Start Integration
                </a>
            @endguest
            @auth
                <div class="flex items-center gap-4">
                    <span class="text-[10px] font-black text-neutral-500 hidden lg:block uppercase tracking-[0.2em]">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn-outline px-5 py-2 text-[10px] font-black uppercase tracking-widest">
                            Sign Out
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</header>
