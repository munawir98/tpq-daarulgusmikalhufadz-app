<aside x-data="{ open: true }" :class="open ? 'w-64' : 'w-20'" class="bg-white dark:bg-gray-900 border-r border-gray-200 dark:border-gray-700
           h-screen flex flex-col transition-all duration-300">

    <!-- Logo -->
    <div class="flex items-center gap-3 p-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            class="w-8 h-8 stroke-blue-600 dark:stroke-blue-400">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
        </svg>

        <span x-show="open" class="font-semibold text-lg dark:text-white">
            TPQ Panel
        </span>
    </div>

    <nav class="flex-1 space-y-1 px-2">

        <!-- Dashboard -->
        <a href="/dashboard" class="menu-item">
            <x-icon name="home" />
            <span x-show="open">Dashboard</span>
        </a>

        <!-- Activity Logs -->
        <a href="/activity-logs" class="menu-item active">
            <x-icon name="document-text" />
            <span x-show="open">Activity Logs</span>
        </a>

        <!-- Santri -->
        <a href="/santri" class="menu-item">
            <x-icon name="user-group" />
            <span x-show="open">Data Santri</span>
        </a>

        <!-- Ustadz -->
        <a href="/ustadz" class="menu-item">
            <x-icon name="academic-cap" />
            <span x-show="open">Data Ustadz</span>
        </a>

    </nav>

    <!-- Toggle Button -->
    <button @click="open = !open" class="p-3 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700">
        <x-icon name="chevron-double-left" x-show="open" />
        <x-icon name="chevron-double-right" x-show="!open" />
    </button>

</aside>

<style>
    .menu-item {
        @apply flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200;
    }

    .menu-item.active {
        @apply bg-blue-600 text-white hover:bg-blue-700;
    }
</style>
