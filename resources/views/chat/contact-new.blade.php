@extends('layouts.mobile')

@section('title', 'Kontak Baru')

@section('header')
<header class="sticky top-0 z-20 bg-blue-600 px-4 pt-4 pb-3 shadow-md overflow-hidden">
    {{-- Decorative blobs --}}
    <div class="absolute top-[-40px] right-[-40px] w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-[-20px] left-[-20px] w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>

    <div class="relative z-10">
        <div class="flex items-center justify-center relative">
            <a href="{{ route('chat.new') }}" class="absolute left-0 text-white/80 hover:text-white transition">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
            </a>
            <h1 class="text-base font-bold text-white tracking-tight">Kontak Baru</h1>
        </div>
    </div>
</header>
@endsection

@section('content')

{{-- Avatar Section --}}
<div class="flex flex-col items-center mb-6 mt-4">
    <div class="relative group">
        <div
            class="w-20 h-20 rounded-full bg-blue-50 dark:bg-slate-800 border-[3px] border-white dark:border-slate-700 overflow-hidden shadow-md flex items-center justify-center">
            <img id="avatarPreview" src="" alt="Avatar" class="w-full h-full object-cover hidden" />
            <span id="avatarPlaceholder"
                class="material-symbols-outlined text-blue-300 dark:text-slate-600 text-4xl">person</span>
        </div>
        <label for="avatarInput"
            class="absolute bottom-0 right-0 bg-blue-600 text-white p-1.5 rounded-full border-2 border-white dark:border-slate-700 shadow flex items-center justify-center hover:scale-105 transition-transform cursor-pointer">
            <span class="material-symbols-outlined text-[16px]">photo_camera</span>
        </label>
        <input type="file" id="avatarInput" accept="image/*" class="hidden" onchange="previewAvatar(event)" />
    </div>
    <p class="mt-2 text-slate-500 dark:text-slate-400 text-[11px] font-medium">Tambah Foto Profil</p>
</div>

{{-- Form Card --}}
<form action="{{ route('chat.contact.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="foto" id="fotoHidden" class="hidden" />

    <div
        class="bg-white dark:bg-slate-900 rounded-xl p-5 shadow-sm border border-slate-100 dark:border-slate-800 space-y-5">

        {{-- Nama Lengkap --}}
        <div class="space-y-1.5">
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Nama Lengkap</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <span class="material-symbols-outlined text-xl">person</span>
                </div>
                <input name="name" type="text" required
                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg py-3 pl-10 pr-4 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 outline-none transition-all text-sm"
                    placeholder="Contoh: Ahmad Fauzi" value="{{ old('name') }}" />
            </div>
            @error('name')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Nomor WhatsApp --}}
        <div class="space-y-1.5">
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Nomor WhatsApp</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <span class="material-symbols-outlined text-xl">phone</span>
                </div>
                <input name="phone" type="tel"
                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg py-3 pl-10 pr-4 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 outline-none transition-all text-sm"
                    placeholder="0812XXXXXXX" value="{{ old('phone') }}" />
            </div>
            @error('phone')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Peran --}}
        <div class="space-y-1.5">
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Peran</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <span class="material-symbols-outlined text-xl">badge</span>
                </div>
                <select name="role"
                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg py-3 pl-10 pr-10 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 outline-none transition-all cursor-pointer text-sm">
                    <option disabled selected value="">Pilih Peran</option>
                    <option value="santri" {{ old('role')=='santri' ? 'selected' : '' }}>Santri</option>
                    <option value="ustadz" {{ old('role')=='ustadz' ? 'selected' : '' }}>Ustadz</option>
                    <option value="wali" {{ old('role')=='wali' ? 'selected' : '' }}>Wali Santri</option>
                </select>
            </div>
            @error('role')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email (Opsional) --}}
        <div class="space-y-1.5">
            <div class="flex justify-between items-center">
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Email</label>
                <span
                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded">Opsional</span>
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                    <span class="material-symbols-outlined text-xl">mail</span>
                </div>
                <input name="email" type="email"
                    class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg py-3 pl-10 pr-4 text-slate-900 dark:text-slate-100 placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 outline-none transition-all text-sm"
                    placeholder="email@contoh.com" value="{{ old('email') }}" />
            </div>
            @error('email')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Success/Error Messages --}}
    @if(session('success'))
    <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-xl text-green-600 text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">check_circle</span>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm flex items-center gap-2">
        <span class="material-symbols-outlined text-lg">error</span>
        {{ session('error') }}
    </div>
    @endif

    {{-- Simpan Button --}}
    <div class="mt-6 pb-4">
        <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-[0.98] flex items-center justify-center gap-2">
            <span class="material-symbols-outlined">save</span>
            <span>Simpan Kontak</span>
        </button>
    </div>
</form>

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

    /* Main content fills remaining screen height */
    main {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
        gap: 0 !important;
        flex: 1 1 auto;
        display: flex;
        flex-direction: column;
    }
</style>
@endpush

@push('scripts')
<script>
    function previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const preview = document.getElementById('avatarPreview');
                const placeholder = document.getElementById('avatarPlaceholder');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);

            // Copy file to the hidden form input
            const fotoInput = document.getElementById('fotoHidden');
            const dt = new DataTransfer();
            dt.items.add(file);
            fotoInput.files = dt.files;
        }
    }
</script>
@endpush
