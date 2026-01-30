<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TPQ Digital')</title>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#13ec5b",
                        "primary-dark": "#0fd24f",
                        "background-light": "#f6f8f6",
                        "background-dark": "#102216",
                    },
                    fontFamily: {
                        display: ["Poppins", "sans-serif"]
                    },
                    borderRadius: {
                        "2xl": "1rem",
                        "3xl": "1.5rem",
                        full: "9999px"
                    },
                    boxShadow: {
                        soft: "0 12px 30px rgba(0,0,0,0.06)"
                    }
                },
            },
        }
    </script>

    <style>
        html,
        body {
            height: 100%;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        body {
            min-height: max(884px, 100dvh);
        }
    </style>

    @stack('styles')
</head>

<body class="bg-background-light dark:bg-background-dark min-h-screen flex justify-center items-start p-0 sm:py-4">

    <!-- Mobile Wrapper -->
    <div
        class="relative flex h-full min-h-screen w-full max-w-md mx-auto flex-col bg-background-light dark:bg-background-dark overflow-x-hidden shadow-2xl pb-24">

        {{-- Header --}}
        @hasSection('header')
        @yield('header')
        @else
        @include('layouts.partials.header')
        @endif

        {{-- Main Content --}}
        <main class="flex flex-col gap-6 px-5 pt-4 pb-6">
            @yield('content')
        </main>

        {{-- Bottom Navigation --}}
        @include('layouts.partials.bottom-nav')

    </div>

    {{-- Scripts --}}
    @stack('scripts')

</body>

</html>
