{{-- Bottom Navigation --}}
@php
$role = session('user.role', 'SANTRI');
$currentRoute = Route::currentRouteName();

// Define navigation items based on role (split for center button)
$leftItems = match($role) {
'ADMIN' => [
['route' => 'admin.dashboard', 'icon' => 'home', 'label' => 'Beranda'],
['route' => 'admin.santri.index', 'icon' => 'group', 'label' => 'Santri'],
],
'USTADZ' => [
['route' => 'ustadz.dashboard', 'icon' => 'home', 'label' => 'Beranda'],
['route' => 'chat.index', 'icon' => 'chat', 'label' => 'Pesan'],
],
default => [
['route' => 'santri.dashboard', 'icon' => 'home', 'label' => 'Beranda'],
['route' => 'santri.jadwal', 'icon' => 'calendar_today', 'label' => 'Jadwal'],
],
};

$rightItems = match($role) {
'ADMIN' => [
['route' => 'admin.ustadz.index', 'icon' => 'school', 'label' => 'Ustadz'],
['route' => 'admin.settings', 'icon' => 'settings', 'label' => 'Setting'],
],
'USTADZ' => [
['route' => 'ustadz.hafalan.index', 'icon' => 'history_edu', 'label' => 'Riwayat'],
['route' => 'profile.index', 'icon' => 'person', 'label' => 'Akun'],
],
default => [
['route' => 'santri.riwayat', 'icon' => 'history_edu', 'label' => 'Riwayat'],
['route' => 'profile.index', 'icon' => 'person', 'label' => 'Profil'],
],
};

$centerButton = match($role) {
'ADMIN' => ['route' => 'admin.settings', 'icon' => 'qr_code_scanner', 'label' => 'QRIS'],
'USTADZ' => ['route' => 'ustadz.dashboard', 'icon' => 'qr_code_scanner', 'label' => 'QRIS'],
default => ['route' => 'santri.presensi', 'icon' => 'fingerprint', 'label' => 'Absen'],
};
@endphp

<nav class="fixed bottom-0 left-0 right-0 w-full max-w-md mx-auto z-50">
    <!-- Nav Background with cutout effect -->
    <div
        class="relative bg-white dark:bg-gray-900 rounded-t-[28px] shadow-[0_-8px_30px_rgba(0,0,0,0.12)] pt-2 pb-0.5 px-2">
        <div class="flex justify-around items-end">
            <!-- Left Items -->
            @foreach($leftItems as $item)
            @php
            $isActive = str_starts_with($currentRoute, explode('.', $item['route'])[0] ?? '');
            @endphp
            <a href="{{ route($item['route']) }}"
                class="flex flex-col items-center gap-0.5 py-1 px-3 {{ $isActive ? 'text-primary' : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-300' }} transition-all active:scale-95">
                <span class="material-symbols-rounded text-2xl">{{ $item['icon'] }}</span>
                <span class="text-[9px] font-semibold">{{ $item['label'] }}</span>
            </a>
            @endforeach

            <!-- Center Button (Floating) -->
            <div class="flex flex-col items-center justify-center -mt-4">
                <a href="{{ route($centerButton['route']) }}"
                    class="w-12 h-12 rounded-full bg-gradient-to-br from-primary via-primary to-primary-dark flex items-center justify-center shadow-[0_6px_20px_rgba(74,144,184,0.4)] ring-[3px] ring-white dark:ring-gray-900 transform hover:scale-110 active:scale-95 transition-all duration-200">
                    <span class="material-symbols-rounded text-white text-2xl">{{ $centerButton['icon'] }}</span>
                </a>
            </div>

            <!-- Right Items -->
            @foreach($rightItems as $item)
            @php
            $isActive = str_starts_with($currentRoute, explode('.', $item['route'])[0] ?? '');
            @endphp
            <a href="{{ route($item['route']) }}"
                class="flex flex-col items-center gap-0.5 py-1 px-3 {{ $isActive ? 'text-primary' : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-300' }} transition-all active:scale-95">
                <span class="material-symbols-rounded text-2xl">{{ $item['icon'] }}</span>
                <span class="text-[9px] font-semibold">{{ $item['label'] }}</span>
            </a>
            @endforeach
        </div>
    </div>
</nav>
