@extends('layouts.app')

@section('title', 'EasyColoc - Modern Living')

@section('content')
    <main>
        <!-- Hero Section -->
        <section class="relative overflow-hidden pt-32 pb-20 lg:pt-48 lg:pb-32 border-b border-border-dark">
            <div class="mx-auto max-w-7xl px-6 relative z-10">
                <div class="flex flex-col items-center text-center max-w-4xl mx-auto">
                    <div class="inline-flex items-center gap-2 rounded-full border border-border-dark bg-surface-dark px-4 py-1.5 text-neutral-400 text-[10px] font-bold uppercase tracking-[0.2em] mb-8">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                        </span>
                        New: Intelligent Sync v2.0
                    </div>
                    <h1 class="text-6xl font-display font-black leading-[1.1] tracking-tight text-white sm:text-8xl mb-10">
                        Shared living, <br/><span class="text-neutral-500">perfectly balanced.</span>
                    </h1>
                    <p class="text-lg leading-relaxed text-neutral-400 mb-12 max-w-2xl font-body">
                        The definitive platform for tracking expenses and managing shared finances. Built for modern housemates who value simplicity and precision.
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-4">
                        <a href="{{ route('register.view') }}" class="btn-modern px-10 py-5 text-sm font-bold">
                            Get Started Free
                        </a>
                        <a href="#features" class="btn-outline px-10 py-5 text-sm font-bold">
                            View Platform
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Background Glow -->
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 -z-10 w-[800px] h-[400px] bg-white opacity-5 blur-[120px] rounded-full"></div>
        </section>

        <!-- Stats Section -->
        <section class="py-24 border-b border-border-dark bg-surface-dark/20">
            <div class="mx-auto max-w-7xl px-6">
                <div class="grid grid-cols-1 gap-12 sm:grid-cols-3">
                    <div class="flex flex-col gap-2">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Active Households</p>
                        <p class="text-5xl font-display font-bold text-white tracking-tighter">2.4k+</p>
                        <div class="h-1 w-12 bg-white/10 mt-2"></div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Capital Managed</p>
                        <p class="text-5xl font-display font-bold text-white tracking-tighter">€1.2M</p>
                        <div class="h-1 w-12 bg-white/10 mt-2"></div>
                    </div>
                    <div class="flex flex-col gap-2">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">System Uptime</p>
                        <p class="text-5xl font-display font-bold text-white tracking-tighter">99.9%</p>
                        <div class="h-1 w-12 bg-white/10 mt-2"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-32">
            <div class="mx-auto max-w-7xl px-6">
                <div class="flex flex-col md:flex-row justify-between items-end gap-8 mb-20">
                    <div class="max-w-xl">
                        <h2 class="text-4xl font-display font-bold text-white mb-6">Built for scale, <br/>designed for focus.</h2>
                        <p class="text-neutral-400 font-body">Everything you need to maintain harmony and financial clarity in your shared home.</p>
                    </div>
                    <a href="{{ route('register.view') }}" class="text-sm font-bold text-white hover:opacity-70 transition-opacity flex items-center gap-2">
                        Explore core architecture <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <div class="p-10 rounded-2xl glass hover-card group">
                        <div class="w-12 h-12 rounded-xl bg-white text-black flex items-center justify-center mb-8">
                            <span class="material-symbols-outlined">receipt_long</span>
                        </div>
                        <h3 class="text-xl font-display font-bold text-white mb-4">Ledger Precision</h3>
                        <p class="text-neutral-500 text-sm leading-relaxed mb-8">
                            Audit-grade expense tracking with instant settlement and balance validation.
                        </p>
                        <div class="w-full h-px bg-white/5 group-hover:bg-white/20 transition-colors"></div>
                    </div>

                    <div class="p-10 rounded-2xl glass hover-card group">
                        <div class="w-12 h-12 rounded-xl bg-white text-black flex items-center justify-center mb-8">
                            <span class="material-symbols-outlined">analytics</span>
                        </div>
                        <h3 class="text-xl font-display font-bold text-white mb-4">Capital Flow</h3>
                        <p class="text-neutral-500 text-sm leading-relaxed mb-8">
                            Visualise your spending patterns and optimize your collective budget with ease.
                        </p>
                        <div class="w-full h-px bg-white/5 group-hover:bg-white/20 transition-colors"></div>
                    </div>

                    <div class="p-10 rounded-2xl glass hover-card group">
                        <div class="w-12 h-12 rounded-xl bg-white text-black flex items-center justify-center mb-8">
                            <span class="material-symbols-outlined">shield</span>
                        </div>
                        <h3 class="text-xl font-display font-bold text-white mb-4">Infrastructure</h3>
                        <p class="text-neutral-500 text-sm leading-relaxed mb-8">
                            Secure role-based access control for owners and verified household members.
                        </p>
                        <div class="w-full h-px bg-white/5 group-hover:bg-white/20 transition-colors"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-32 px-6">
            <div class="mx-auto max-w-5xl">
                <div class="relative overflow-hidden rounded-[2.5rem] bg-white text-black p-12 md:p-24 text-center">
                    <h2 class="text-5xl md:text-7xl font-display font-black tracking-tighter mb-10">Unify your shared economy.</h2>
                    <p class="text-lg text-black/60 mb-12 max-w-xl mx-auto font-body">
                        Join the next generation of housemates managing their lives with financial clarity.
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-4">
                        <a href="{{ route('register.view') }}" class="bg-black text-white px-10 py-5 rounded-xl font-bold hover:scale-[0.98] transition-transform">
                            Create Workspace
                        </a>
                        <a href="{{ route('login.view') }}" class="border border-black/10 px-10 py-5 rounded-xl font-bold hover:bg-black/5 transition-colors">
                            Member Sign In
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
