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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

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
                        "neutral-600": "#52525b",
                        "neutral-800": "#27272a",
                        "neutral-900": "#18181b",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"],
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
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, .font-display {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass {
            background: rgba(18, 18, 20, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .modern-border {
            border: 1px solid #1f1f22;
        }

        .btn-modern {
            @apply flex items-center justify-center gap-2 rounded-xl bg-white px-6 py-3 text-sm font-bold text-black transition-all hover:bg-neutral-200 active:scale-95 disabled:opacity-50 disabled:pointer-events-none;
        }

        .btn-outline {
            @apply flex items-center justify-center gap-2 rounded-xl border border-border-dark bg-transparent px-6 py-3 text-sm font-bold text-white transition-all hover:bg-white hover:text-black active:scale-95;
        }

        .hover-card {
            @apply transition-all duration-300 hover:border-neutral-700 hover:bg-white/[0.02];
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #09090b;
        }

        ::-webkit-scrollbar-thumb {
            background: #27272a;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #3f3f46;
        }
    </style>
</head>
<body class="font-sans antialiased">
    @auth
        @include('partials.sidebar')
    @endauth

    <div class="@auth lg:ml-72 @endauth min-h-screen flex flex-col">
        <!-- Mobile Top Bar -->
        <header class="sticky top-0 z-30 lg:hidden border-b border-border-dark bg-background-dark/80 backdrop-blur-md px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white text-black font-display font-black text-sm">E</div>
                <span class="font-display font-bold text-white tracking-tight">EasyColoc</span>
            </a>
            @auth
            <button onclick="toggleSidebar()" class="p-2 text-neutral-400 hover:text-white transition-colors">
                <span class="material-symbols-outlined">menu</span>
            </button>
            @endauth
        </header>

        <!-- Dynamic Header -->
        @guest
            @include('partials.header')
        @endguest

        <main class="flex-1 w-full @guest max-w-7xl mx-auto @endguest">
            {{ $slot ?? '' }}
            @yield('content')
        </main>

        @guest
            @include('partials.footer')
        @endguest
    </div>

    @include('partials.flash-message')
    @yield('modals')

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('main-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (sidebar) sidebar.classList.toggle('-translate-x-full');
            if (overlay) overlay.classList.toggle('hidden');
        }

        if (document.getElementById('sidebar-overlay')) {
            document.getElementById('sidebar-overlay').addEventListener('click', toggleSidebar);
        }
    </script>
</body>
</html>
