<nav class="relative flex justify-end items-center px-6 py-4
            bg-white dark:bg-gray-900 shadow-sm border-b border-gray-200 dark:border-gray-700">

    <h1 class="text-xl font-bold dark:text-gray-200 absolute left-1/2 -translate-x-1/2">
        {{ $title }}
    </h1>

    <div class="flex items-center gap-4">

        <!-- THEME SWITCH -->
        <button onclick="toggleTheme()" class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700">
            <x-icon name="moon" class="w-6 h-6" />
        </button>

        <!-- PROFILE -->
        <x-navbar-profile />
    </div>
</nav>

<script>
    function toggleTheme() {
        document.documentElement.classList.toggle('dark')
        localStorage.setItem('theme',
            document.documentElement.classList.contains('dark') ? 'dark' : 'light'
        )
    }
</script>
