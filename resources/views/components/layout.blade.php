<!DOCTYPE html>
<html lang="en" class="dark:bg-gray-900">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'TPQ Panel' }}</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body x-data="{
        sidebarOpen: true,

        /* ICONS */
        icons: {
            home: `<path stroke-linecap='round' stroke-linejoin='round' d='M3 12l9-9 9 9v9a2 2 0 01-2 2H5a2 2 0 01-2-2v-9z' />`,
            'document-text': `<path stroke-linecap='round' stroke-linejoin='round' d='M12 4H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V9l-5-5zm0 5h5' />`,
            'user-group': `<path stroke-linecap='round' stroke-linejoin='round' d='M17 20v-2a4 4 0 00-3-3.87M9 14.13A4 4 0 006 18v2m9-14a3 3 0 11-6 0 3 3 0 016 0z' />`,
            'academic-cap': `<path stroke-linecap='round' stroke-linejoin='round' d='M12 14l9-5-9-5-9 5 9 5v6a6 6 0 1112 0' />`,
            'chevron': `<path stroke-linecap='round' stroke-linejoin='round' d='M15 19l-7-7 7-7' />`,
        },

        /* MENU */
        menu: [
            { label:'Dashboard', url:'/dashboard', icon:'home',
                active: {{ request()->is('dashboard') ? 'true' : 'false' }} },

            { label:'Activity Logs', url:'/activity-logs', icon:'document-text',
                active: {{ request()->is('activity-logs') ? 'true' : 'false' }} },

            { label:'Data Santri', url:'/santri', icon:'user-group',
                active: {{ request()->is('santri') ? 'true' : 'false' }} },

            { label:'Data Ustadz', url:'/ustadz', icon:'academic-cap',
                active: {{ request()->is('ustadz') ? 'true' : 'false' }} },

            {
                label:'Master Data',
                icon:'user-group',
                open:false,
                badge:4,
                active:false,
                children:[
                    { label:'Kelas', url:'/kelas',
                      active: {{ request()->is('kelas') ? 'true' : 'false' }} },

                    { label:'Mapel', url:'/mapel', active:false },

                    { label:'Group Belajar', url:'/group', active:false },
                ]
            }
        ],
    }" class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-200 flex">

    <!-- SIDEBAR -->
    <x-sidebar-premium />

    <!-- CONTENT -->
    <div class="transition-all duration-300 w-full" :class="sidebarOpen ? 'ml-64' : 'ml-20'">

        <x-navbar :title="$title ?? ''" />
        <x-toast />

        <main class="p-6">
            {{ $slot }}
        </main>
    </div>


    <!-- DARK MODE -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            if (localStorage.getItem('theme') === 'dark')
                document.documentElement.classList.add('dark');
        });

        function toggleTheme() {
            const dark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', dark ? 'dark' : 'light');
        }
    </script>

</body>

</html>
