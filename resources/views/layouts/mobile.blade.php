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
                        primary: "#00A8C5",
                        "primary-dark": "#007E95",
                        "header-blue": "#00BDDE",
                        "header-dark": "#008FAC",
                        "background-light": "#F8FAFC",
                        "background-dark": "#0F172A",
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
            min-height: 100vh;
            overflow-y: auto;
            /* Enable native scroll */
        }
    </style>

    @stack('styles')
</head>

<body
    class="bg-background-light dark:bg-background-dark min-h-screen flex justify-center items-start @hasSection('no-pb') p-0 sm:pt-4 sm:pb-0 @else p-0 sm:py-4 @endif">

    <!-- Mobile Wrapper -->
    <div
        class="relative flex h-full min-h-screen w-full max-w-md md:max-w-2xl mx-auto flex-col bg-background-light dark:bg-background-dark shadow-2xl md:text-lg @hasSection('no-pb') pb-0 @elseif(isset($hideBottomNav) && $hideBottomNav) pb-0 @else pb-24 @endif">

        {{-- Header --}}
        @hasSection('header')
        @yield('header')
        @else
        @include('layouts.partials.header')
        @endif

        {{-- Main Content --}}
        <main
            class="flex flex-col @hasSection('no-gap') gap-0 @else gap-6 @endif @hasSection('no-px') px-0 @else px-5 @endif @hasSection('no-pt') pt-0 @else pt-4 @endif pb-6">
            @yield('content')
        </main>

        {{-- Bottom Navigation --}}
        @unless(isset($hideBottomNav) && $hideBottomNav)
            @hasSection('bottom-nav')
            @yield('bottom-nav')
            @else
            @include('layouts.partials.bottom-nav')
            @endif
        @endunless

    </div>

    {{-- Scripts --}}
    @stack('scripts')

</body>

</html>
