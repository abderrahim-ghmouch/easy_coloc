<!DOCTYPE html>

<html class="dark" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title', 'EasyColoc - Modern Living')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Inter:wght@100..900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#FFFFFF",
                        "background-dark": "#09090b",
                        "surface-dark": "#18181b",
                        "border-dark": "#27272a",
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

        h1, h2, h3, h4, .font-display {
            font-family: 'Outfit', sans-serif;
        }

        .glass {
            background: rgba(24, 24, 27, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .modern-border {
            border: 1px solid #27272a;
        }

        .hover-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-card:hover {
            border-color: #52525b;
            background: #18181b;
            transform: translateY(-2px);
        }

        .btn-modern {
            background: #fafafa;
            color: #09090b;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-modern:hover {
            opacity: 0.9;
            transform: scale(0.98);
        }

        .btn-outline {
            background: transparent;
            color: #fafafa;
            border: 1px solid #27272a;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-outline:hover {
            background: #18181b;
            border-color: #52525b;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #09090b; }
        ::-webkit-scrollbar-thumb { background: #27272a; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #3f3f46; }

        input, select, textarea {
            background-color: #09090b !important;
            border-color: #27272a !important;
            color: #fafafa !important;
        }
        
        input:focus, select:focus, textarea:focus {
            border-color: #52525b !important;
            ring: 0 !important;
            outline: none !important;
        }
    </style>
</head>

<body
    class="font-body bg-background-dark text-slate-100 selection:bg-white selection:text-black antialiased">
    @include('partials.header')
    
    <div class="min-h-screen">
        @yield('content')
    </div>

    @yield('modals')
    @include('partials.flash-message')
    @include('partials.footer')
</body>

</html>
