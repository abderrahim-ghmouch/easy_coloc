<x-app-layout>
    <div class="flex flex-col gap-8">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div class="flex flex-col gap-1">
                <div class="flex items-center gap-2 text-primary text-sm font-bold uppercase tracking-wider mb-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-1 hover:underline">
                        <span class="material-symbols-outlined text-base">arrow_back</span>
                        Back to Dashboard
                    </a>
                </div>
                <h1 class="text-4xl font-extrabold tracking-tight">{{ $colocation->name }}</h1>
                <p class="text-slate-500 dark:text-primary/60 flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">calendar_today</span>
                    Est. {{ $colocation->created_at->format('M Y') }} • 
                    <span class="material-symbols-outlined text-base">group</span>
                    {{ $colocation->members->count() }} Members
                </p>
            </div>
            
            <div class="flex items-center gap-3">
                @if(auth()->user()->id === $colocation->owner_id)
                    <form action="{{ route('colocation.destroy', $colocation) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this colocation?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500/10 border border-red-500/20 text-red-500 font-bold px-6 py-3 rounded-xl hover:bg-red-500 hover:text-white transition-all flex items-center gap-2">
                            <span class="material-symbols-outlined text-base">delete</span>
                            Delete Flatshare
                        </button>
                    </form>
                @endif
                <button class="bg-primary hover:bg-primary/90 text-background-dark font-bold px-6 py-3 rounded-xl transition-all flex items-center gap-2 shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined">add</span>
                    Add Expense
                </button>
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Left Column: Summary & Activity --}}
            <div class="lg:col-span-2 flex flex-col gap-8">
                
                {{-- Stats Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white/5 border border-primary/20 rounded-2xl p-6">
                        <p class="text-[10px] uppercase font-bold text-primary/40 mb-1">Total Spent</p>
                        <p class="text-3xl font-extrabold text-white">0.00€</p>
                    </div>
                    <div class="bg-white/5 border border-primary/20 rounded-2xl p-6">
                        <p class="text-[10px] uppercase font-bold text-amber-400/40 mb-1">Your Balance</p>
                        <p class="text-3xl font-extrabold text-amber-400">0.00€</p>
                    </div>
                    <div class="bg-white/5 border border-primary/20 rounded-2xl p-6">
                        <p class="text-[10px] uppercase font-bold text-green-400/40 mb-1">Status</p>
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                            <span class="text-lg font-bold text-white">All Settled</span>
                        </div>
                    </div>
                </div>

                {{-- Recent Activity --}}
                <div class="bg-white/5 border border-primary/20 rounded-2xl overflow-hidden shadow-xl">
                    <div class="p-6 border-b border-white/10 flex justify-between items-center">
                        <h3 class="text-xl font-bold flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">history</span>
                            Recent Expenses
                        </h3>
                        <button class="text-primary text-sm font-bold hover:underline">View All</button>
                    </div>
                    
                    <div class="p-20 text-center flex flex-col items-center gap-4">
                        <div class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center text-slate-500">
                            <span class="material-symbols-outlined text-3xl">receipt_long</span>
                        </div>
                        <p class="text-slate-400">No expenses recorded yet. Be the first!</p>
                    </div>
                </div>
            </div>

            {{-- Right Column: Members & Quick Actions --}}
            <div class="flex flex-col gap-8">
                
                {{-- Members List --}}
                <div class="bg-white/5 border border-primary/20 rounded-2xl overflow-hidden shadow-xl">
                    <div class="p-6 border-b border-white/10">
                        <h3 class="text-xl font-bold flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">group</span>
                            Members
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        @foreach($colocation->members as $member)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-primary/20 rounded-full flex items-center justify-center text-primary font-bold">
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-100">{{ $member->name }}</p>
                                        <p class="text-[10px] uppercase text-primary/60 tracking-wider">
                                            {{ $member->pivot->role }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold {{ $member->balance >= 0 ? 'text-green-400' : 'text-amber-400' }}">
                                        0.00€
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="p-4 bg-white/5 border-t border-white/10 text-center text-sm font-bold text-primary hover:bg-primary/5 transition-all cursor-pointer">
                        Invite New Member
                    </div>
                </div>

                {{-- Who owes who --}}
                <div class="bg-white/5 border border-primary/20 rounded-2xl overflow-hidden shadow-xl">
                    <div class="p-6 border-b border-white/10">
                        <h3 class="text-xl font-bold flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">swap_horiz</span>
                            Who Owes Who
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="p-8 text-center flex flex-col items-center gap-3">
                            <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined text-2xl">done_all</span>
                            </div>
                            <p class="text-sm text-slate-400">All balances are currently settled. Great job!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
