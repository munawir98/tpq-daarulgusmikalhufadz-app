@extends('layouts.mobile')

@section('title', 'Mulai Chat Baru')

@section('header')
<header class="bg-blue-600 px-4 pt-12 pb-4 flex items-center gap-4 text-white shadow-md">
    <a href="{{ route('chat.index') }}"
        class="flex items-center justify-center p-1 rounded-full hover:bg-white/10 transition-colors">
        <span class="material-symbols-outlined text-2xl">arrow_back_ios_new</span>
    </a>
    <h1 class="text-xl font-bold tracking-tight">Mulai Chat Baru</h1>
</header>
@endsection

@section('content')

{{-- Search Bar --}}
<div class="-mx-5 -mt-4 px-4 py-4 bg-white dark:bg-background-dark">
    <label class="flex flex-col w-full">
        <div
            class="flex w-full items-center rounded-xl bg-slate-100 dark:bg-slate-800/50 h-12 px-4 border border-transparent focus-within:border-blue-500/50 transition-all">
            <span class="material-symbols-outlined text-slate-500 dark:text-slate-400">search</span>
            <input id="searchInput" onkeyup="filterContacts()"
                class="w-full border-none bg-transparent focus:ring-0 text-slate-900 dark:text-slate-100 placeholder:text-slate-500 dark:placeholder:text-slate-400 text-sm font-medium"
                placeholder="Cari nama atau peran (Santri/Ustadz)..." type="text" />
        </div>
    </label>
</div>

{{-- Quick Actions --}}
<div class="-mx-5 px-2 py-2">
    <button
        class="w-full flex items-center gap-4 p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
        <div
            class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600">
            <span class="material-symbols-outlined">group_add</span>
        </div>
        <span class="text-base font-semibold">Grup Baru</span>
    </button>
    <a href="{{ route('chat.contact.new') }}"
        class="w-full flex items-center gap-4 p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
        <div
            class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600">
            <span class="material-symbols-outlined">person_add</span>
        </div>
        <span class="text-base font-semibold">Kontak Baru</span>
    </a>
    <button
        class="w-full flex items-center gap-4 p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
        <div
            class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600">
            <span class="material-symbols-outlined">hub</span>
        </div>
        <span class="text-base font-semibold">Komunitas Baru</span>
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
            class="bg-slate-50/50 dark:bg-slate-900/20 px-4 py-2 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest sticky top-0 z-10 backdrop-blur-sm">
            {{ $letter }}
        </div>
        <div class="px-2">
            @foreach($group as $contact)
            @php
            $c = is_array($contact) ? (object) $contact : $contact;
            $name = $c->name ?? $c->nama_lengkap ?? 'Tanpa Nama';
            $role = $c->role ?? $c->peran ?? '';
            $foto = $c->foto ?? $c->avatar ?? null;
            $isUstadz = str_contains(strtolower($role), 'ustadz') || str_contains(strtolower($role), 'ustadzah');
            $isOnline = $c->is_online ?? false;
            $contactId = $c->id ?? 0;
            @endphp
            <a href="{{ route('chat.room', $contactId) }}"
                class="contact-item flex items-center gap-4 p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 cursor-pointer transition-colors"
                data-name="{{ strtolower($name) }}" data-role="{{ strtolower($role) }}">
                <div class="relative">
                    @if($foto)
                    <img alt="{{ $name }}" class="h-12 w-12 rounded-full object-cover"
                        src="{{ asset('storage/' . $foto) }}" />
                    @else
                    <div
                        class="h-12 w-12 rounded-full flex items-center justify-center
                                    {{ $isUstadz ? 'bg-blue-100 dark:bg-blue-900/30' : 'bg-slate-100 dark:bg-slate-800' }}">
                        <span class="text-lg font-bold {{ $isUstadz ? 'text-blue-600' : 'text-slate-500' }}">
                            {{ mb_substr($name, 0, 1) }}
                        </span>
                    </div>
                    @endif
                    @if($isOnline)
                    <div
                        class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-green-500 border-2 border-white dark:border-background-dark">
                    </div>
                    @endif
                </div>
                <div class="flex-1 border-b border-slate-100 dark:border-slate-800 pb-3">
                    <h4 class="font-bold text-slate-900 dark:text-slate-100">{{ $name }}</h4>
                    @if($role)
                    <p
                        class="text-xs font-medium {{ $isUstadz ? 'text-blue-600' : 'text-slate-500 dark:text-slate-400' }}">
                        {{ $role }}
                    </p>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
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
