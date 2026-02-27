<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13ec49",
                        "background-light": "#f6f8f6",
                        "background-dark": "#102215",
                        "sidebar-dark": "#0a140d",
                    },
                    fontFamily: {
                        "display": ["Manrope"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <title>My Flatshares History - EasyColoc</title>
</head>

<body class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100 min-h-screen">
    <div class="flex h-screen overflow-hidden">
        <x-sidebar/>
        <div class="flex-1 flex flex-col h-screen overflow-y-auto">

            <main class="flex-1 p-8 flex flex-col gap-8 max-w-7xl mx-auto w-full">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div class="flex flex-col gap-1">
                        <h1 class="text-3xl font-extrabold tracking-tight">My Flatshares</h1>
                        <p class="text-slate-500 dark:text-primary/60">Manage your current and past residential
                            histories</p>
                    </div>
                    <button
                        class="bg-primary hover:bg-primary/90 text-background-dark font-bold px-6 py-3 rounded-xl transition-all flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
                        <span class="material-symbols-outlined">add_circle</span>
                        Create New Flatshare
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              
                    <div
                        class="bg-slate-100 dark:bg-primary/5 border border-slate-200 dark:border-primary/20 rounded-2xl p-6 shadow-xl flex flex-col gap-5 hover:border-primary/40 transition-all relative overflow-hidden group">
                        <div class="absolute top-0 right-0 p-4">
                            <span
                                class="bg-primary/20 text-primary text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                                Active
                            </span>
                        </div>
                        <div class="flex flex-col gap-1 mt-2">
                            <h3 class="text-xl font-bold group-hover:text-primary transition-colors">The Green Villa
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-primary/60 flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">calendar_today</span>
                                Jan 2022 - Present
                            </p>
                        </div>
                        <div class="grid grid-cols-2 gap-4 py-4 border-y border-slate-200 dark:border-primary/10">
                            <div class="flex flex-col gap-1">
                                <span
                                    class="text-[10px] uppercase font-bold text-slate-400 dark:text-primary/40">Members</span>
                                <div class="flex items-center gap-1 font-semibold">
                                    <span class="material-symbols-outlined text-base">group</span>
                                    4 Members
                                </div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-[10px] uppercase font-bold text-slate-400 dark:text-primary/40">Final
                                    Balance</span>
                                <div class="flex items-center gap-1 font-bold text-amber-500">
                                    <span class="material-symbols-outlined text-base">pending_actions</span>
                                    Pending 12€
                                </div>
                            </div>
                        </div>
                        <button
                            class="w-full bg-primary hover:bg-primary/90 text-background-dark font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">dashboard</span>
                            Enter Dashboard
                        </button>
                    </div>
                    <div
                        class="bg-slate-100 dark:bg-primary/5 border border-slate-200 dark:border-primary/10 rounded-2xl p-6 shadow-sm flex flex-col gap-5 opacity-80 hover:opacity-100 transition-all group relative">
                        <div class="absolute top-0 right-0 p-4">
                            <span
                                class="bg-slate-200 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                                Left
                            </span>
                        </div>
                        <div class="flex flex-col gap-1 mt-2">
                            <h3 class="text-xl font-bold">Downtown Loft</h3>
                            <p class="text-sm text-slate-500 dark:text-primary/60 flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">calendar_today</span>
                                June 2020 - Dec 2021
                            </p>
                        </div>
                        <div class="grid grid-cols-2 gap-4 py-4 border-y border-slate-200 dark:border-primary/10">
                            <div class="flex flex-col gap-1">
                                <span
                                    class="text-[10px] uppercase font-bold text-slate-400 dark:text-primary/40">Members</span>
                                <div class="flex items-center gap-1 font-semibold">
                                    <span class="material-symbols-outlined text-base">group</span>
                                    3 Members
                                </div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-[10px] uppercase font-bold text-slate-400 dark:text-primary/40">Final
                                    Balance</span>
                                <div class="flex items-center gap-1 font-bold text-primary">
                                    <span class="material-symbols-outlined text-base">check_circle</span>
                                    Settled
                                </div>
                            </div>
                        </div>
                        <button
                            class="w-full border border-slate-300 dark:border-primary/20 hover:bg-primary/10 hover:text-primary text-slate-600 dark:text-slate-300 font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">history</span>
                            View History
                        </button>
                    </div>
                    <div
                        class="bg-slate-100 dark:bg-primary/5 border border-slate-200 dark:border-primary/10 rounded-2xl p-6 shadow-sm flex flex-col gap-5 opacity-80 hover:opacity-100 transition-all group relative">
                        <div class="absolute top-0 right-0 p-4">
                            <span
                                class="bg-slate-200 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">
                                Left
                            </span>
                        </div>
                        <div class="flex flex-col gap-1 mt-2">
                            <h3 class="text-xl font-bold">Sunrise Apartment</h3>
                            <p class="text-sm text-slate-500 dark:text-primary/60 flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">calendar_today</span>
                                Feb 2019 - May 2020
                            </p>
                        </div>
                        <div class="grid grid-cols-2 gap-4 py-4 border-y border-slate-200 dark:border-primary/10">
                            <div class="flex flex-col gap-1">
                                <span
                                    class="text-[10px] uppercase font-bold text-slate-400 dark:text-primary/40">Members</span>
                                <div class="flex items-center gap-1 font-semibold">
                                    <span class="material-symbols-outlined text-base">group</span>
                                    2 Members
                                </div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-[10px] uppercase font-bold text-slate-400 dark:text-primary/40">Final
                                    Balance</span>
                                <div class="flex items-center gap-1 font-bold text-primary">
                                    <span class="material-symbols-outlined text-base">check_circle</span>
                                    Settled
                                </div>
                            </div>
                        </div>
                        <button
                            class="w-full border border-slate-300 dark:border-primary/20 hover:bg-primary/10 hover:text-primary text-slate-600 dark:text-slate-300 font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">history</span>
                            View History
                        </button>
                    </div>
                </div>
                <footer class="mt-auto pt-12 text-center text-slate-400 text-sm">
                    <div class="flex justify-center gap-6 mb-4">
                        <a class="hover:text-primary transition-colors" href="#">Privacy Policy</a>
                        <a class="hover:text-primary transition-colors" href="#">Help Center</a>
                        <a class="hover:text-primary transition-colors" href="#">Support</a>
                    </div>
                    © 2024 EasyColoc. Built for harmonious living.
                </footer>
            </main>
        </div>
    </div>
</body>
</html>
