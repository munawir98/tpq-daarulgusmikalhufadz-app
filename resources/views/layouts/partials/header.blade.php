{{-- Header Partial --}}
<header
    class="sticky top-0 z-10 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md border-b border-gray-100 dark:border-gray-800">
    <div class="flex items-center justify-between px-5 py-4">
        <div class="flex flex-col">
            <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Assalamu'alaikum,</span>
            <h2 class="text-xl font-bold leading-tight tracking-tight text-[#111813] dark:text-white">
                {{ session('user.name', Auth::user()->name ?? 'User') }}
            </h2>
        </div>
        <div class="flex items-center gap-3">
            {{-- Notification Button --}}
            <a href="{{ route('notifications.index') }}"
                class="relative flex items-center justify-center size-10 rounded-full bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <span class="material-symbols-outlined text-gray-600 dark:text-gray-300"
                    style="font-size: 24px;">notifications</span>
                @if(isset($unreadNotifications) && $unreadNotifications > 0)
                <span
                    class="absolute -top-1 -right-1 flex h-5 min-w-[20px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-bold text-white border-2 border-white dark:border-gray-800 shadow-sm">
                    {{ $unreadNotifications > 99 ? '99+' : $unreadNotifications }}
                </span>
                @endif
            </a>
            {{-- Profile Avatar --}}
            <a href="{{ route('profile.index') }}"
                class="size-10 rounded-full bg-gray-200 dark:bg-gray-700 overflow-hidden border border-gray-100 dark:border-gray-600 flex items-center justify-center">
                @if(session('user.foto'))
                <img alt="Profile" class="w-full h-full object-cover"
                    src="{{ Str::startsWith(session('user.foto'), 'data:') ? session('user.foto') : asset('storage/' . session('user.foto')) }}" />
                @else
                <span class="text-lg font-bold text-gray-500">{{ substr(session('user.name', 'U'), 0, 1) }}</span>
                @endif
            </a>
        </div>
    </div>
</header>
