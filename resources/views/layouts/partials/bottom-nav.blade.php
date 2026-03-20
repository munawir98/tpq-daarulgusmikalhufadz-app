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
['route' => 'profile.index', 'icon' => 'settings', 'label' => 'Setting'],
],
default => [
['route' => 'santri.hafalan.index', 'icon' => 'history_edu', 'label' => 'Riwayat'],
['route' => 'profile.index', 'icon' => 'settings', 'label' => 'Setting'],
],
};

$centerButton = match($role) {
'ADMIN' => ['route' => 'presensi.index', 'icon' => 'qr_code_scanner', 'label' => 'Presensi'],
'USTADZ' => ['route' => 'ustadz.biometric.attendance', 'icon' => 'qr_code_scanner', 'label' => 'Scan QR'],
default => ['route' => 'santri.presensi.index', 'icon' => 'qr_code_scanner', 'label' => 'Absen'],
};
@endphp

@php
$position = $position ?? 'fixed';
$customClass = $customClass ?? '';
$theme = $theme ?? 'blue';
$isBlue = $theme === 'blue';

if ($position === 'absolute') {
    $positionClass = 'absolute bottom-0';
} else {
    $positionClass = 'fixed bottom-0';
}
$navClass = trim($positionClass . ' ' . $customClass);
$containerClass = $containerClass ?? 'rounded-t-[24px]';

$bgClass = $isBlue ? 'bg-transparent' : 'bg-white dark:bg-gray-900';
$itemIsActive = $isBlue ? 'text-white' : 'text-primary';
$itemIsInactive = $isBlue ? 'text-white/80' : 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-300';
$ringClass = $isBlue ? 'ring-header-blue' : 'ring-white dark:ring-gray-900';
$shadowClass = $isBlue ? '' : 'shadow-[0_-8px_30px_rgba(0,0,0,0.12)]';
@endphp



<nav class="{{ $navClass }} left-0 right-0 w-full max-w-md mx-auto z-50">
    <!-- Nav Background with cutout effect -->
    <div
        class="relative {{ $bgClass }} {{ $containerClass }} {{ $shadowClass }} pt-5 pb-5 px-2">
        <div class="flex justify-around items-end">
            <!-- Left Items -->
            @foreach($leftItems as $item)
            @php
            $isActive = str_starts_with($currentRoute, explode('.', $item['route'])[0] ?? '');
            @endphp
            <a href="{{ route($item['route']) }}"
                class="flex flex-col items-center gap-0.5 py-0 px-3 {{ $isActive ? $itemIsActive : $itemIsInactive }} transition-all active:scale-95">
                <span class="material-symbols-rounded text-[20px]">{{ $item['icon'] }}</span>
                <span class="text-[8px] font-semibold">{{ $item['label'] }}</span>
            </a>
            @endforeach

            <!-- Center Button (Floating) -->
            <div class="flex flex-col items-center justify-center -mt-3.5">
                <a href="{{ route($centerButton['route']) }}"
                    class="w-10 h-10 rounded-full bg-gradient-to-br from-primary via-primary to-primary-dark flex items-center justify-center shadow-[0_6px_20px_rgba(74,144,184,0.4)] ring-[2px] {{ $ringClass }} transform hover:scale-110 active:scale-95 transition-all duration-200">
                    <span class="material-symbols-rounded text-white text-xl">{{ $centerButton['icon'] }}</span>
                </a>
            </div>

            <!-- Right Items -->
            @foreach($rightItems as $item)
            @php
            $isActive = str_starts_with($currentRoute, explode('.', $item['route'])[0] ?? '');
            @endphp
            <a href="{{ route($item['route']) }}"
                class="flex flex-col items-center gap-0.5 py-0 px-3 {{ $isActive ? $itemIsActive : $itemIsInactive }} transition-all active:scale-95">
                <span class="material-symbols-rounded text-[20px]">{{ $item['icon'] }}</span>
                <span class="text-[8px] font-semibold">{{ $item['label'] }}</span>
            </a>
            @endforeach
        </div>
    </div>
</nav>
