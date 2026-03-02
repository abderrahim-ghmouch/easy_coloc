<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>EasyColoc - Manage your flatshare effortlessly</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Limelight&family=Inter:wght@400;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <script>
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                    colors: {
                        "primary": "#018749", // Celtic Green
                        "accent": "#fee101",   // Celtic Gold
                        "background-dark": "#001a11", // Deep Forest
                    },
                    fontFamily: {
                        "display": ["Limelight", "cursive"],
                        "sans": ["Inter", "sans-serif"]
                    },
                    },
                },
            }
        </script>
        <style>
            h1, h2, h3 { font-family: 'Limelight', cursive; text-transform: uppercase; letter-spacing: 0.05em; }
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="antialiased font-display bg-background-dark text-slate-100 selection:bg-primary selection:text-background-dark">
        <div class="relative min-h-screen">
            <!-- Navigation -->
            <nav class="sticky top-0 z-50 bg-background-dark/80 backdrop-blur-md border-b border-primary/10">
                <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-primary">
                        <span class="material-symbols-outlined text-4xl">home_work</span>
                        <span class="font-bold text-2xl tracking-tight text-white">EasyColoc</span>
                    </div>

                    <div class="flex items-center gap-6">
                        @if (Route::has('login'))
                            <livewire:welcome.navigation />
                        @endif
                    </div>
                </div>
            </nav>

            <!-- Hero Section -->
            <main>
                <section class="relative pt-20 pb-32 overflow-hidden">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[600px] bg-primary/20 blur-[120px] rounded-full -z-10 opacity-30"></div>
                    
                    <div class="max-w-7xl mx-auto px-6 text-center">
                        <h1 class="text-6xl md:text-7xl font-extrabold tracking-tight mb-8">
                            Harmonious Living, <br/>
                            <span class="text-primary">Efortless Management</span>
                        </h1>
                        <p class="text-xl text-slate-400 max-w-2xl mx-auto mb-12">
                            The ultimate platform for flatshares. Track expenses, manage settlements, and communicate with your roommates all in one place.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                            @auth
                                <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-8 py-4 bg-primary text-background-dark font-bold rounded-xl hover:bg-primary/90 transition-all flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
                                    Go to Dashboard
                                    <span class="material-symbols-outlined">dashboard</span>
                                </a>
                            @else
                                <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-primary text-background-dark font-bold rounded-xl hover:bg-primary/90 transition-all flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
                                    Get Started Free
                                    <span class="material-symbols-outlined">arrow_forward</span>
                                </a>
                                <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-white/5 border border-primary/20 text-white font-bold rounded-xl hover:bg-white/10 transition-all">
                                    Sign In
                                </a>
                            @endauth
                        </div>
                    </div>
                </section>

                <!-- Features -->
                <section class="py-24 bg-white/5 border-y border-primary/10">
                    <div class="max-w-7xl mx-auto px-6">
                        <div class="grid md:grid-cols-3 gap-12">
                            <div class="p-8 bg-background-dark/50 border border-primary/10 rounded-3xl hover:border-primary/30 transition-all group">
                                <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-3xl">account_balance_wallet</span>
                                </div>
                                <h3 class="text-2xl font-bold mb-4">Expense Tracking</h3>
                                <p class="text-slate-400">Scan receipts and split bills with ease. No more "who owes who" confusion.</p>
                            </div>
                            
                            <div class="p-8 bg-background-dark/50 border border-primary/10 rounded-3xl hover:border-primary/30 transition-all group">
                                <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-3xl">receipt_long</span>
                                </div>
                                <h3 class="text-2xl font-bold mb-4">Fast Settlements</h3>
                                <p class="text-slate-400">Settle debts with a single click. Keep your roommate relationships healthy.</p>
                            </div>
                            
                            <div class="p-8 bg-background-dark/50 border border-primary/10 rounded-3xl hover:border-primary/30 transition-all group">
                                <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform">
                                    <span class="material-symbols-outlined text-3xl">group</span>
                                </div>
                                <h3 class="text-2xl font-bold mb-4">Roommate Hub</h3>
                                <p class="text-slate-400">A centralized place for announcements, chores, and flatshare history.</p>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

        </div>
    </body>
</html>
