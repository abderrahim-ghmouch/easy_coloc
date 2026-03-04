@auth
    @php
        $is_owner = false; // This would normally be calculated in the view or controller
        // For the sidebar navigation, we'll use consistent routes
    @endphp
    <aside id="main-sidebar" class="fixed left-0 top-0 z-40 h-screen w-72 -translate-x-full border-r border-border-dark bg-background-dark transition-transform lg:translate-x-0">
        <div class="flex h-full flex-col px-6 py-8">
            <!-- Logo area -->
            <div class="mb-12">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white text-black font-display font-black text-xl shadow-lg shadow-white/10">
                        E
                    </div>
                    <h2 class="text-xl font-display font-bold tracking-tight text-white group-hover:opacity-80 transition-opacity">
                        Easy<span class="text-neutral-500">Coloc</span>
                    </h2>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 space-y-2">
                <p class="mb-4 text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-600 px-2">Main Menu</p>
                
                <a href="{{ route('home') }}" class="flex items-center gap-3 rounded-xl px-4 py-3.5 text-sm font-medium transition-all {{ request()->routeIs('home') ? 'bg-white text-black shadow-lg shadow-white/5' : 'text-neutral-400 hover:bg-surface-dark hover:text-white' }}">
                    <span class="material-symbols-outlined text-lg">home</span>
                    Home
                </a>

                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-xl px-4 py-3.5 text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-white text-black shadow-lg shadow-white/5' : 'text-neutral-400 hover:bg-surface-dark hover:text-white' }}">
                    <span class="material-symbols-outlined text-lg">dashboard</span>
                    Dashboard
                </a>

                <a href="{{ route('colocation.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3.5 text-sm font-medium transition-all {{ request()->routeIs('colocation.*') ? 'bg-white text-black shadow-lg shadow-white/5' : 'text-neutral-400 hover:bg-surface-dark hover:text-white' }}">
                    <span class="material-symbols-outlined text-lg">grid_view</span>
                    Colocations
                </a>

                @if (auth()->user()->role == 'ADMIN')
                    <div class="pt-6">
                        <p class="mb-4 text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-600 px-2">Administration</p>
                        <a href="{{ route('admin.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3.5 text-sm font-medium transition-all {{ request()->routeIs('admin.*') ? 'bg-white text-black shadow-lg shadow-white/5' : 'text-neutral-400 hover:bg-surface-dark hover:text-white' }}">
                            <span class="material-symbols-outlined text-lg">admin_panel_settings</span>
                            Admin Panel
                        </a>
                    </div>
                @endif
            </nav>

            <!-- User area -->
            <div class="mt-auto pt-8 border-t border-border-dark flex flex-col gap-4">
                <div class="flex items-center gap-3 px-2">
                    <div class="h-10 w-10 rounded-full border border-border-dark bg-surface-dark flex items-center justify-center text-xs font-bold text-white">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-white">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] text-neutral-500 uppercase tracking-widest">{{ Auth::user()->role }}</span>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="post" class="w-full">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-red-500 hover:bg-red-500/10 transition-all">
                        <span class="material-symbols-outlined text-lg">logout</span>
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="sidebar-overlay" class="fixed inset-0 z-30 bg-black/60 backdrop-blur-sm hidden lg:hidden"></div>
@endauth
