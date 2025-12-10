<div x-data="themeColor()" class="relative">

    <button @click="open = !open" class="px-3 py-2 rounded bg-gray-200 dark:bg-gray-700">
        🎨 Theme
    </button>

    <div x-show="open" x-transition
        class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded shadow-lg p-3 z-50">

        <p class="text-xs font-semibold mb-2 dark:text-white">Theme Color</p>

        <template x-for="(label, key) in colors">
            <button @click="setColor(key)" class="theme-btn" x-text="label"></button>
        </template>

    </div>

</div>

<script>
    function themeColor() {
        return {
            open: false,
            colors: {
                blue: "🔵 Blue",
                purple: "🟣 Purple",
                emerald: "💚 Emerald",
                rose: "🌹 Rose"
            },
            init() {
                const saved = localStorage.getItem('theme-color');
                if (saved) document.documentElement.dataset.theme = saved;
            },
            setColor(color) {
                document.documentElement.dataset.theme = color;
                localStorage.setItem('theme-color', color);
                this.open = false;
            }
        }
    }
</script>

<style>
    .theme-btn {
        @apply w-full text-left px-2 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700;
    }
</style>
