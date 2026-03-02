<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <script>
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        colors: {
                            "primary": "#13ec49",
                            "background-light": "#f6f8f6",
                            "background-dark": "#102215",
                        },
                        fontFamily: {
                            "display": ["Manrope"]
                        },
                    },
                },
            }
        </script>
    </head>
    <body class="antialiased font-display bg-background-dark text-slate-100 selection:bg-primary selection:text-background-dark overflow-x-hidden">
        <div class="min-h-screen relative flex items-center justify-center p-6">
            <!-- Background Glows -->
            <div class="absolute top-[20%] left-[10%] w-[500px] h-[500px] bg-primary/20 blur-[120px] rounded-full -z-10 opacity-40"></div>
            <div class="absolute bottom-[20%] right-[10%] w-[400px] h-[400px] bg-primary/10 blur-[100px] rounded-full -z-10 opacity-30"></div>

            <div class="w-full max-w-lg">
                <!-- Header Branding -->
                <div class="text-center mb-10">
                    <a href="/" wire:navigate class="inline-flex items-center gap-3 text-primary group">
                        <span class="material-symbols-outlined text-5xl group-hover:scale-110 transition-transform duration-300">home_work</span>
                        <span class="text-white text-3xl font-extrabold tracking-tight">EasyColoc</span>
                    </a>
                </div>

                <!-- Content Card -->
                <div class="bg-white/[0.03] backdrop-blur-xl border border-primary/20 rounded-3xl shadow-2xl overflow-hidden shadow-primary/5">
                    {{ $slot }}
                </div>

            </div>
        </div>
    </body>
</html>
