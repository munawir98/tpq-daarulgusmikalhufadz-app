@if(Auth::check())

<div x-data="{ open:false }" class="relative">

    <button @click="open = !open" class="flex items-center gap-3 px-3 py-2 bg-gray-200 dark:bg-gray-700 rounded-lg">

        <img src="{{ Auth::user()->foto ?? 'https://ui-avatars.com/api/?name='.Auth::user()->name }}"
            class="w-8 h-8 rounded-full">

        <span class="hidden md:block dark:text-white">{{ Auth::user()->name }}</span>
    </button>

    <div x-show="open" x-transition
        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded shadow-lg p-3 z-50">

        <p class="font-semibold dark:text-white">{{ Auth::user()->name }}</p>
        <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">{{ Auth::user()->role }}</p>

        <a href="/profile" class="dropdown-item">Profile</a>
        <a href="/settings" class="dropdown-item">Settings</a>

        <form action="/logout" method="POST">
            @csrf
            <button class="dropdown-item text-red-600 hover:bg-red-600 hover:text-white">
                Logout
            </button>
        </form>

    </div>

</div>

@else

<!-- Jika belum login, tampilkan tombol Login -->
<a href="/login" class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
    Login
</a>

@endif

<style>
    .dropdown-item {
        @apply block px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700;
    }
</style>
