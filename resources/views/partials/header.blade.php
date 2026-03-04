<header class="sticky top-0 z-50 w-full border-b border-border-dark bg-background-dark/80 backdrop-blur-md">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-white text-black font-display font-black text-xl">
                E
            </div>
            <h2 class="text-xl font-display font-bold tracking-tight text-white group-hover:opacity-80 transition-opacity">
                Easy<span class="text-neutral-400">Coloc</span>
            </h2>
        </a>

        @php
            function isActive($name)
            {
                $activeClass = 'text-white border-b border-white';
                $inactiveClass = 'text-neutral-400 hover:text-white transition-colors';
                return request()->routeIs($name) ? $activeClass : $inactiveClass;
            }
        @endphp

        <nav class="hidden md:flex items-center gap-8 font-body text-sm">
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
                <a href="{{ route('login.view') }}"
                    class="hidden sm:block text-sm font-medium text-neutral-400 hover:text-white transition-colors">
                    Log In
                </a>
                <a href="{{ route('register.view') }}"
                    class="btn-modern px-5 py-2 text-xs">
                    Get Started
                </a>
            @endguest
            @auth
                <div class="flex items-center gap-4">
                    <span class="text-xs font-medium text-neutral-500 hidden lg:block uppercase tracking-wider">{{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn-outline px-4 py-2 text-xs">
                            Sign Out
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</header>
