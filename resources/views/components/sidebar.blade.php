<aside class="w-64 flex-shrink-0 bg-sidebar-dark border-r border-primary/10 flex flex-col z-50 overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center gap-3 text-primary">
                    <span class="material-symbols-outlined text-3xl">home_work</span>
                    <h2 class="text-white text-lg font-bold leading-tight tracking-tight">EasyColoc</h2>
                </div>
            </div>
            <nav class="flex-1 px-4 space-y-2 mt-4">
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-primary/10 hover:text-primary transition-all group"
                    href="#">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-primary/10 hover:text-primary transition-all group"
                    href="#">
                    <span class="material-symbols-outlined">account_balance_wallet</span>
                    <span class="font-medium">Expenses</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-primary/10 hover:text-primary transition-all group"
                    href="#">
                    <span class="material-symbols-outlined">receipt_long</span>
                    <span class="font-medium">Settlements</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg bg-primary text-background-dark font-bold shadow-lg shadow-primary/20 transition-all"
                    href="#">
                    <span class="material-symbols-outlined">history</span>
                    <span>My Flatshares</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-primary/10 hover:text-primary transition-all group"
                    href="{{ route('profile') }}">
                    <span class="material-symbols-outlined">person</span>
                    <span class="font-medium">Profile</span>
                </a>
            </nav>
            <div class="p-4 border-t border-primary/10 space-y-2">
                <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-400 hover:bg-primary/10 hover:text-primary transition-all group"
                    href="#">
                    <span class="material-symbols-outlined">settings</span>
                    <span class="font-medium">Settings</span>
                </a>
                <button
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-red-400 hover:bg-red-500/10 transition-all group">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="font-medium">Logout</span>
                </button>
            </div>
        </aside>
