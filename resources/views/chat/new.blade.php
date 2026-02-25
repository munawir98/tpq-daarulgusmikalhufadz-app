@extends('layouts.mobile')

@section('title', 'Mulai Chat Baru')

@section('header')
<header class="sticky top-0 z-20 bg-blue-600 px-4 pt-4 pb-3 text-white shadow-md">
    <h1 class="text-base font-bold tracking-tight text-center">Mulai Chat Baru</h1>
    {{-- Search Bar --}}
    <div class="mt-3">
        <label class="flex flex-col w-full">
            <div
                class="flex w-full items-center rounded-xl bg-white/20 h-10 px-3 border border-transparent focus-within:border-white/50 transition-all">
                <span class="material-symbols-outlined text-white/70">search</span>
                <input id="searchInput" onkeyup="filterContacts()"
                    class="w-full border-none bg-transparent focus:ring-0 text-white placeholder:text-white/60 text-sm font-medium"
                    placeholder="Cari nama atau peran (Santri/Ustadz)..." type="text" />
            </div>
        </label>
    </div>
</header>
@endsection

@section('content')

{{-- Quick Actions --}}
<div class="-mx-5 px-2 py-2">
    <button
        class="w-full flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
        <div
            class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600">
            <span class="material-symbols-outlined">group_add</span>
        </div>
        <span class="text-sm font-semibold">Grup Baru</span>
    </button>
    <a href="{{ route('chat.contact.new') }}"
        class="w-full flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
        <div
            class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600">
            <span class="material-symbols-outlined">person_add</span>
        </div>
        <span class="text-sm font-semibold">Kontak Baru</span>
    </a>
    <button
        class="w-full flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
        <div
            class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600">
            <span class="material-symbols-outlined">hub</span>
        </div>
        <span class="text-sm font-semibold">Komunitas Baru</span>
    </button>
</div>

{{-- Divider --}}
<div class="-mx-5 h-2 bg-slate-50 dark:bg-slate-900/50 border-y border-slate-100 dark:border-slate-800"></div>

{{-- Contact List --}}
<div id="contactList" class="-mx-5">
    @php
    // Group contacts by first letter
    $grouped = $contacts->groupBy(function ($contact) {
    $c = is_array($contact) ? (object) $contact : $contact;
    $name = $c->name ?? $c->nama_lengkap ?? 'Z';
    return strtoupper(mb_substr($name, 0, 1));
    })->sortKeys();
    @endphp

    @forelse($grouped as $letter => $group)
    <div class="contact-section" data-letter="{{ $letter }}">
        <div
            class="bg-slate-50/50 dark:bg-slate-900/20 px-4 py-1.5 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest border-t border-slate-200 dark:border-slate-700">
            {{ $letter }}
        </div>

        @foreach($group as $contact)
        @php
        $c = is_array($contact) ? (object) $contact : $contact;
        $name = $c->name ?? $c->nama_lengkap ?? 'Tanpa Nama';
        $role = strtoupper($c->role ?? $c->peran ?? '');
        $foto = $c->foto ?? $c->avatar ?? null;
        $isUstadz = str_contains(strtolower($role), 'ustadz') || str_contains(strtolower($role), 'ustadzah');
        $isSantri = str_contains(strtolower($role), 'santri');
        $isOnline = $c->is_online ?? false;
        $contactId = $c->id ?? 0;

        // Generate unique color per contact
        $avatarColors = [
        ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-600'],
        ['bg' => 'bg-emerald-100 dark:bg-emerald-900/30', 'text' => 'text-emerald-600'],
        ['bg' => 'bg-purple-100 dark:bg-purple-900/30', 'text' => 'text-purple-600'],
        ['bg' => 'bg-rose-100 dark:bg-rose-900/30', 'text' => 'text-rose-600'],
        ['bg' => 'bg-amber-100 dark:bg-amber-900/30', 'text' => 'text-amber-600'],
        ['bg' => 'bg-cyan-100 dark:bg-cyan-900/30', 'text' => 'text-cyan-600'],
        ['bg' => 'bg-pink-100 dark:bg-pink-900/30', 'text' => 'text-pink-600'],
        ['bg' => 'bg-indigo-100 dark:bg-indigo-900/30', 'text' => 'text-indigo-600'],
        ['bg' => 'bg-teal-100 dark:bg-teal-900/30', 'text' => 'text-teal-600'],
        ['bg' => 'bg-orange-100 dark:bg-orange-900/30', 'text' => 'text-orange-600'],
        ];
        $colorIndex = crc32($name) % count($avatarColors);
        $avatarColor = $avatarColors[abs($colorIndex)];
        @endphp
        <a href="{{ route('chat.room', $contactId) }}"
            class="contact-item flex items-center gap-3 px-4 py-2 border-b border-slate-100 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer transition-colors"
            data-name="{{ strtolower($name) }}" data-role="{{ strtolower($role) }}">
            <div class="relative">
                @if($foto)
                <img alt="{{ $name }}" class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $foto) }}"
                    onerror="this.style.display='none';this.nextElementSibling.style.display='flex';" />
                <div class="h-10 w-10 rounded-full items-center justify-center bg-slate-200 dark:bg-slate-700"
                    style="display:none;">
                    <span class="material-symbols-outlined text-slate-500 dark:text-slate-400 text-xl">person</span>
                </div>
                @else
                <div class="h-10 w-10 rounded-full flex items-center justify-center bg-slate-200 dark:bg-slate-700">
                    <span class="material-symbols-outlined text-slate-500 dark:text-slate-400 text-xl">person</span>
                </div>
                @endif
                @if($isOnline)
                <div
                    class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-green-500 border-2 border-white dark:border-background-dark">
                </div>
                @endif
            </div>
            <div class="flex-1">
                <h4 class="text-xs font-semibold text-slate-900 dark:text-slate-100">{{ $name }}</h4>
                @if($role)
                <p
                    class="text-[11px] font-semibold {{ $isUstadz ? 'text-red-500' : ($isSantri ? 'text-blue-600' : 'text-slate-500 dark:text-slate-400') }}">
                    {{ $role }}
                </p>
                @endif
            </div>
        </a>
        @endforeach
    </div>
    @empty
    {{-- Empty State --}}
    <div class="flex flex-col items-center justify-center py-20 text-center">
        <div
            class="size-24 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-full flex items-center justify-center mb-5 shadow-inner">
            <span class="material-symbols-outlined text-gray-400 dark:text-gray-500"
                style="font-size: 48px;">contacts</span>
        </div>
        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Belum Ada Kontak</h3>
    </div>
    @endforelse
</div>

@endsection

@section('bottom-nav')
<div class="hidden"></div>
@endsection

@push('styles')
<style>
    /* Remove bottom padding since no nav on this page */
    .pb-24 {
        padding-bottom: 0 !important;
    }
</style>
@endpush

@push('scripts')
<script>
    function filterContacts() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const items = document.querySelectorAll('.contact-item');
        const sections = document.querySelectorAll('.contact-section');

        items.forEach(item => {
            const name = item.getAttribute('data-name') || '';
            const role = item.getAttribute('data-role') || '';
            item.style.display = (name.includes(query) || role.includes(query)) ? 'flex' : 'none';
        });

        // Hide section headers if no visible contacts
        sections.forEach(section => {
            const visibleItems = section.querySelectorAll('.contact-item[style*="flex"], .contact-item:not([style])');
            const hiddenCount = section.querySelectorAll('.contact-item[style*="none"]').length;
            const totalItems = section.querySelectorAll('.contact-item').length;
            section.style.display = (hiddenCount === totalItems) ? 'none' : 'block';
        });
    }
</script>
@endpush
