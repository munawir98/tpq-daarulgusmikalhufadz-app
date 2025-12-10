<div class="fixed left-0 top-0 h-screen bg-white/70 dark:bg-gray-900/70 backdrop-blur-lg
           border-r border-gray-200 dark:border-gray-700 shadow-lg
           transition-all duration-300 z-50 flex flex-col" :class="sidebarOpen ? 'w-64' : 'w-20'">

    <!-- LOGO -->
    <div class="flex items-center gap-3 px-4 py-4">
        <div class="p-2 rounded-lg bg-blue-600 text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 12l9-9 9 9v9a2 2 0 01-2 2H5a2 2 0 01-2-2v-9z" />
            </svg>
        </div>

        <span class="font-bold text-lg dark:text-gray-200" x-show="sidebarOpen" x-transition.opacity>
            TPQ Panel
        </span>
    </div>

    <!-- MENU -->
    <nav class="mt-2 px-3 space-y-1 overflow-y-auto flex-1">

        <template x-for="(item, i) in menu" :key="i">
            <div>

                <!-- MAIN ITEM -->
                <a :href="item.url ?? '#'" class="sidebar-item" :class="item.active ? 'active' : ''"
                    @click="item.children ? item.open = !item.open : null">

                    <!-- ACTIVE BAR -->
                    <div x-show="item.active" x-transition
                        class="absolute left-0 top-0 h-full w-1 bg-blue-600 rounded-r-lg"></div>

                    <!-- ICON -->
                    <svg class="w-6 h-6 stroke-gray-700 dark:stroke-gray-200" fill="none" stroke-width="1.5"
                        viewBox="0 0 24 24" x-html="icons[item.icon]">
                    </svg>

                    <!-- LABEL -->
                    <span x-text="item.label" x-show="sidebarOpen" x-transition></span>

                    <!-- BADGE -->
                    <span x-show="sidebarOpen && item.badge"
                        class="ml-auto px-2 py-0.5 bg-blue-600 text-white rounded-lg text-xs"
                        x-text="item.badge"></span>

                    <!-- ARROW -->
                    <svg x-show="item.children && sidebarOpen" class="w-4 h-4 ml-auto transition-transform"
                        :class="item.open ? 'rotate-180' : ''" fill="none" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </a>

                <!-- CHILD MENU -->
                <div x-show="item.children && item.open" x-transition.scale.origin.top class="ml-10 mt-1 space-y-1">

                    <template x-for="(child, j) in item.children" :key="j">
                        <a :href="child.url" class="sidebar-item pl-3" :class="child.active ? 'active' : ''">
                            <span x-text="child.label"></span>
                        </a>
                    </template>

                </div>

            </div>
        </template>

    </nav>

    <!-- COLLAPSE BUTTON -->
    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
        <button @click="sidebarOpen = !sidebarOpen"
            class="w-full flex items-center justify-center p-2 bg-gray-200 dark:bg-gray-800 rounded-lg">

            <svg class="w-6 h-6 stroke-gray-700 dark:stroke-gray-200 transition-all duration-300" fill="none"
                stroke-width="1.5" :class="sidebarOpen ? '' : 'rotate-180'">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>

        </button>
    </div>
</div>


<!-- STYLE -->
<style>
    .sidebar-item {
        @apply relative flex items-center gap-3 px-3 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all;
    }

    .sidebar-item.active {
        @apply bg-blue-600 text-white shadow-md;
    }

    .sidebar-item.active svg {
        @apply stroke-white;
    }
</style>
