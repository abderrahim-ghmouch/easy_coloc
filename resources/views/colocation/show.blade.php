<x-app-layout>
    <div class="flex flex-col gap-8">
        @if (session('success'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-500 font-bold px-6 py-4 rounded-xl flex items-center gap-3">
                <span class="material-symbols-outlined text-green-500">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

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
                <button 
                    x-data=""
                    @click="$dispatch('open-modal', 'add-expense')"
                    class="bg-primary hover:bg-primary/90 text-background-dark font-bold px-6 py-3 rounded-xl transition-all flex items-center gap-2 shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined">add</span>
                    Add Expense
                </button>
            </div>
        </div>

        @php
            $totalSpent = $colocation->expenses->sum('montant');
            $memberCount = $colocation->members->count();
            $sharePerPerson = $memberCount > 0 ? $totalSpent / $memberCount : 0;
            $userPaid = $colocation->expenses->where('user_id', auth()->id())->sum('montant');
            $userBalance = $userPaid - $sharePerPerson;
        @endphp

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Left Column: Summary & Activity --}}
            <div class="lg:col-span-2 flex flex-col gap-8">
                
                {{-- Stats Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white/5 border border-primary/20 rounded-2xl p-6">
                        <p class="text-[10px] uppercase font-bold text-primary/40 mb-1">Total Spent</p>
                        <p class="text-3xl font-extrabold text-white">{{ number_format($totalSpent, 2) }}€</p>
                    </div>
                    <div class="bg-white/5 border border-primary/20 rounded-2xl p-6">
                        <p class="text-[10px] uppercase font-bold text-{{ $userBalance >= 0 ? 'green-400' : 'amber-400' }}/40 mb-1">Your Balance</p>
                        <p class="text-3xl font-extrabold text-{{ $userBalance >= 0 ? 'green-400' : 'amber-400' }}">
                            {{ ($userBalance >= 0 ? '+' : '') . number_format($userBalance, 2) }}€
                        </p>
                    </div>
                    <div class="bg-white/5 border border-primary/20 rounded-2xl p-6">
                        <p class="text-[10px] uppercase font-bold text-green-400/40 mb-1">Status</p>
                        <div class="flex items-center gap-2">
                            @if(abs($userBalance) < 0.01)
                                <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                                <span class="text-lg font-bold text-white">All Settled</span>
                            @else
                                <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span>
                                <span class="text-lg font-bold text-white">Pending</span>
                            @endif
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
                    
                    @if($colocation->expenses->isEmpty())
                        <div class="p-20 text-center flex flex-col items-center gap-4">
                            <div class="w-16 h-16 bg-white/5 rounded-full flex items-center justify-center text-slate-500">
                                <span class="material-symbols-outlined text-3xl">receipt_long</span>
                            </div>
                            <p class="text-slate-400">No expenses recorded yet. Be the first!</p>
                        </div>
                    @else
                        <div class="divide-y divide-white/10">
                            @foreach($colocation->expenses->sortByDesc('date')->take(10) as $expense)
                                <div class="p-4 flex items-center justify-between hover:bg-white/5 transition-all">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
                                            <span class="material-symbols-outlined">
                                                {{ match($expense->category) {
                                                    'food' => 'shopping_cart',
                                                    'rent' => 'home',
                                                    'utilities' => 'bolt',
                                                    default => 'receipt'
                                                } }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="font-bold text-white">{{ $expense->title }}</p>
                                            <p class="text-xs text-slate-500">
                                                Paid by <span class="text-primary">{{ $expense->user->name }}</span> • {{ \Carbon\Carbon::parse($expense->date)->format('M d, Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-white">{{ number_format($expense->montant, 2) }}€</p>
                                        <p class="text-[10px] uppercase text-slate-500 tracking-wider">Per person: {{ number_format($expense->montant / $memberCount, 2) }}€</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
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
                            @php
                                $memberPaid = $colocation->expenses->where('user_id', $member->id)->sum('montant');
                                $memberBalance = $memberPaid - $sharePerPerson;
                            @endphp
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
                                    <p class="text-sm font-bold {{ $memberBalance >= 0 ? 'text-green-400' : 'text-amber-400' }}">
                                        {{ ($memberBalance >= 0 ? '+' : '') . number_format($memberBalance, 2) }}€
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
                        @php
                            $creditors = [];
                            $debtors = [];
                            foreach($colocation->members as $member) {
                                $paid = $colocation->expenses->where('user_id', $member->id)->sum('montant');
                                $bal = $paid - $sharePerPerson;
                                if ($bal > 0.01) $creditors[] = ['name' => $member->name, 'amount' => $bal];
                                elseif ($bal < -0.01) $debtors[] = ['name' => $member->name, 'amount' => abs($bal)];
                            }
                        @endphp

                        @if(empty($creditors) || empty($debtors))
                            <div class="p-8 text-center flex flex-col items-center gap-3">
                                <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-2xl">done_all</span>
                                </div>
                                <p class="text-sm text-slate-400">All balances are currently settled. Great job!</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($debtors as $debtor)
                                    <div class="text-sm text-slate-400">
                                        <span class="font-bold text-amber-400">{{ $debtor['name'] }}</span> owes 
                                        <span class="font-bold text-green-400">{{ number_format($debtor['amount'], 2) }}€</span> in total.
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Expense Modal --}}
    <x-modal name="add-expense" :show="$errors->isNotEmpty()" maxWidth="lg" focusable>
        <div class="p-8">
            <h2 class="text-2xl font-extrabold flex items-center gap-3 mb-6">
                <span class="material-symbols-outlined text-primary">add_circle</span>
                Add New Expense
            </h2>

            <form action="{{ route('expenses.store', $colocation) }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <x-input-label for="title" value="Title" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" placeholder="e.g. Groceries, Electricity bill" required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="montant" value="Amount (€)" />
                        <x-text-input id="montant" name="montant" type="number" step="0.01" class="mt-1 block w-full" placeholder="0.00" required />
                        <x-input-error :messages="$errors->get('montant')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="date" value="Date" />
                        <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" value="{{ date('Y-m-d') }}" required />
                        <x-input-error :messages="$errors->get('date')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <x-input-label for="category" value="Category" />
                    <select id="category" name="category" class="mt-1 block w-full border-sidebar-light bg-sidebar-dark text-slate-200 focus:border-primary focus:ring-primary rounded-xl shadow-sm transition-all">
                        <option value="general">General</option>
                        <option value="food">Food & Groceries</option>
                        <option value="rent">Rent</option>
                        <option value="utilities">Utilities (Water, Gas, Electricity)</option>
                        <option value="other">Other</option>
                    </select>
                    <x-input-error :messages="$errors->get('category')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="description" value="Description (Optional)" />
                    <textarea id="description" name="description" rows="3" class="mt-1 block w-full border-sidebar-light bg-sidebar-dark text-slate-200 focus:border-primary focus:ring-primary rounded-xl shadow-sm transition-all" placeholder="Add more details..."></textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <x-secondary-button x-on:click="$dispatch('close-modal', 'add-expense')">
                        Cancel
                    </x-secondary-button>

                    <button type="submit" class="bg-primary hover:bg-primary/90 text-background-dark font-bold px-8 py-2 rounded-xl transition-all shadow-lg shadow-primary/20">
                        Record Expense
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
</x-app-layout>
