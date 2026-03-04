@extends('layouts.app')

@section('title', 'Dashboard | EasyColoc')

@section('content')
    <main class="mx-auto w-full max-w-5xl flex-1 px-6 py-12">
        <!-- Dashboard Header -->
        <div class="mb-12 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-4xl font-display font-bold text-white tracking-tight">Overview</h1>
                <p class="text-neutral-500 font-body mt-2">Personal expenditure analytics for this cycle.</p>
            </div>
            <div class="relative">
                <form action="" method="get" onchange="this.submit()">
                    <input type="month" name="month-year" value="{{ request('month-year') }}"
                        class="w-full rounded-lg border border-border-dark bg-background-dark px-4 py-2.5 text-sm font-medium focus:border-white focus:ring-0 transition-colors"
                        id="month-select" />
                </form>
            </div>
        </div>

        <!-- Metric Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="p-8 rounded-2xl glass modern-border relative overflow-hidden group">
                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500 mb-4">Total Expenditure</p>
                <h2 class="text-5xl font-display font-medium text-white tracking-tighter">€{{ number_format($total_amounts, 2) }}</h2>
                
                <div class="mt-6 flex items-center gap-2 text-xs font-medium text-emerald-500">
                    <span class="material-symbols-outlined text-sm">trending_up</span>
                    <span>12% from last cycle</span>
                </div>
                
                <div class="absolute -right-4 -bottom-4 opacity-[0.03] group-hover:opacity-[0.05] transition-opacity">
                    <span class="material-symbols-outlined text-9xl">payments</span>
                </div>
            </div>

            <!-- Add more metrics if needed, for now I'll stick to a clean layout -->
            <div class="md:col-span-2 p-8 rounded-2xl modern-border bg-surface-dark/50 flex items-center justify-between">
                <div class="max-w-xs">
                    <h3 class="text-lg font-bold text-white">System Status: Active</h3>
                    <p class="text-sm text-neutral-500 mt-1">Your colocation accounts are synchronized and verified.</p>
                </div>
                <a href="{{ route('colocations.index') }}" class="btn-modern text-xs">Manage Groups</a>
            </div>
        </div>

        <!-- Ledger Section -->
        <div class="mb-6 flex items-center justify-between">
            <h3 class="text-xl font-display font-bold text-white">Recent Ledger</h3>
            <button class="text-xs font-bold text-neutral-500 hover:text-white transition-colors uppercase tracking-widest">Download CSV</button>
        </div>

        <div class="overflow-hidden rounded-2xl modern-border bg-surface-dark/30 backdrop-blur-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-border-dark bg-surface-dark/50">
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Description</th>
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Category</th>
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Date</th>
                            <th class="px-8 py-5 text-right text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-dark font-body">
                        @forelse ($expenses as $expense)
                            <tr class="group hover:bg-white/[0.02] transition-colors">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/5 border border-white/10 text-white group-hover:bg-white group-hover:text-black transition-all">
                                            <span class="material-symbols-outlined text-xl">receipt</span>
                                        </div>
                                        <span class="font-medium text-white">{{ $expense->title }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-neutral-900 border border-border-dark text-[10px] font-bold text-neutral-400 uppercase tracking-widest">{{ $expense->category->name }}</span>
                                </td>
                                <td class="px-8 py-6 text-sm text-neutral-500">
                                    {{ $expense->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-8 py-6 text-right font-display font-medium text-white text-lg">
                                    €{{ number_format($expense->amount, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-16 text-center text-neutral-500 italic font-body">No entries found for this cycle.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
