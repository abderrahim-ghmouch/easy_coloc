<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'EasyColoc'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Scripts & Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#FFFFFF",
                        "background-dark": "#09090b",
                        "surface-dark": "#121214",
                        "border-dark": "#1f1f22",
                        "accent": "#FFFFFF",
                        "neutral-400": "#a1a1aa",
                        "neutral-500": "#71717a",
                        "neutral-800": "#27272a",
                        "neutral-900": "#18181b",
                    },
                    fontFamily: {
                        "display": ["Outfit", "sans-serif"],
                        "body": ["Inter", "sans-serif"],
                    },
                },
            },
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #09090b;
            color: #fafafa;
        }
        .glass {
            background: rgba(18, 18, 20, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .modern-border {
            border: 1px solid #1f1f22;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-background-dark">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div class="mb-10">
            <a href="/" class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white text-black font-display font-black text-2xl shadow-xl shadow-white/10">
                    E
                </div>
                <h1 class="text-3xl font-display font-bold text-white tracking-tighter">Easy<span class="text-neutral-500">Coloc</span></h1>
            </a>
        </div>

        <div class="w-full sm:max-w-md px-10 py-12 glass modern-border shadow-2xl overflow-hidden sm:rounded-3xl">
            {{ $slot }}
        </div>
        
        <div class="mt-8 text-center text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-600">
            &copy; {{ date('Y') }} EasyColoc Infrastructure. All rights reserved.
        </div>
    </div>
</body>
</html>
