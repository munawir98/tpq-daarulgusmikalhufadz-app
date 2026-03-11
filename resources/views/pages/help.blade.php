@extends('layouts.mobile')

@section('title', 'Bantuan')

@php
    $hideBottomNav = true;
@endphp

@section('header')
<header
    class="sticky top-0 z-10 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md border-b border-gray-100 dark:border-gray-800">
    <div class="flex items-center justify-center gap-2 px-4 py-2.5">
        <h2 class="text-lg font-bold">Bantuan</h2>
    </div>
</header>
@endsection

@section('content')

{{-- Search --}}
<div class="relative">
    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[18px]">search</span>
    <input type="text" placeholder="Cari pertanyaan..."
        class="w-full pl-9 pr-3 py-2 rounded-xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-xs focus:ring-2 focus:ring-primary/50" />
</div>

{{-- FAQ Categories --}}
<div class="flex flex-wrap gap-1.5">
    <button class="px-2.5 py-1 rounded-full bg-primary text-[#102216] text-[10px] font-semibold">Semua</button>
    <button
        class="px-2.5 py-1 rounded-full bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-[10px] font-medium border border-gray-200 dark:border-gray-700">Presensi</button>
    <button
        class="px-2.5 py-1 rounded-full bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-[10px] font-medium border border-gray-200 dark:border-gray-700">Hafalan</button>
    <button
        class="px-2.5 py-1 rounded-full bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-[10px] font-medium border border-gray-200 dark:border-gray-700">Akun</button>
</div>

{{-- FAQ List --}}
<div class="flex flex-col gap-2">
    {{-- FAQ Item 1 --}}
    <details
        class="group bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
        <summary class="flex items-center justify-between p-2.5 cursor-pointer">
            <div class="flex items-center gap-2.5">
                <div class="shrink-0 size-7 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined">location_on</span>
                </div>
                <span class="font-semibold text-sm text-[#111813] dark:text-white">Bagaimana cara presensi?</span>
            </div>
            <span
                class="material-symbols-outlined text-gray-400 group-open:rotate-180 transition-transform">expand_more</span>
        </summary>
        <div class="px-2.5 pb-2.5 text-[11px] text-gray-600 dark:text-gray-400 leading-relaxed">
            <ol class="list-decimal list-inside space-y-2 mt-2">
                <li>Pastikan GPS aktif di perangkat Anda</li>
                <li>Buka menu Presensi dari dashboard</li>
                <li>Pastikan Anda berada dalam radius 100m dari TPQ</li>
                <li>Scan QR Code atau tap Presensi Manual</li>
                <li>Tunggu konfirmasi berhasil</li>
            </ol>
        </div>
    </details>

    {{-- FAQ Item 2 --}}
    <details
        class="group bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
        <summary class="flex items-center justify-between p-3 cursor-pointer">
            <div class="flex items-center gap-3">
                <div
                    class="shrink-0 size-10 rounded-xl bg-orange-50 dark:bg-orange-900/30 flex items-center justify-center text-orange-500">
                    <span class="material-symbols-outlined">menu_book</span>
                </div>
                <span class="font-semibold text-sm text-[#111813] dark:text-white">Cara melihat riwayat hafalan?</span>
            </div>
            <span
                class="material-symbols-outlined text-gray-400 group-open:rotate-180 transition-transform">expand_more</span>
        </summary>
        <div class="px-2.5 pb-2.5 text-[11px] text-gray-600 dark:text-gray-400 leading-relaxed">
            Buka menu "Riwayat" di bottom navigation. Di sana Anda bisa melihat semua setoran hafalan beserta nilai dan
            catatan dari ustadz.
        </div>
    </details>

    {{-- FAQ Item 3 --}}
    <details
        class="group bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
        <summary class="flex items-center justify-between p-3 cursor-pointer">
            <div class="flex items-center gap-3">
                <div
                    class="shrink-0 size-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-500">
                    <span class="material-symbols-outlined">lock</span>
                </div>
                <span class="font-semibold text-sm text-[#111813] dark:text-white">Lupa password, bagaimana?</span>
            </div>
            <span
                class="material-symbols-outlined text-gray-400 group-open:rotate-180 transition-transform">expand_more</span>
        </summary>
        <div class="px-2.5 pb-2.5 text-[11px] text-gray-600 dark:text-gray-400 leading-relaxed">
            Hubungi Admin TPQ untuk reset password Anda. Siapkan NIS/Email yang terdaftar sebagai verifikasi.
        </div>
    </details>

    {{-- FAQ Item 4 --}}
    <details
        class="group bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
        <summary class="flex items-center justify-between p-3 cursor-pointer">
            <div class="flex items-center gap-3">
                <div
                    class="shrink-0 size-10 rounded-xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center text-purple-500">
                    <span class="material-symbols-outlined">notifications</span>
                </div>
                <span class="font-semibold text-sm text-[#111813] dark:text-white">Notifikasi tidak muncul?</span>
            </div>
            <span
                class="material-symbols-outlined text-gray-400 group-open:rotate-180 transition-transform">expand_more</span>
        </summary>
        <div class="px-2.5 pb-2.5 text-[11px] text-gray-600 dark:text-gray-400 leading-relaxed">
            Pastikan notifikasi diaktifkan di Profil > Notifikasi. Juga cek pengaturan notifikasi di browser/perangkat
            Anda.
        </div>
    </details>
    {{-- FAQ Item 5 --}}
    <details
        class="group bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
        <summary class="flex items-center justify-between p-3 cursor-pointer">
            <div class="flex items-center gap-3">
                <div
                    class="shrink-0 size-10 rounded-xl bg-red-50 dark:bg-red-900/30 flex items-center justify-center text-red-500">
                    <span class="material-symbols-outlined">fingerprint</span>
                </div>
                <span class="font-semibold text-sm text-[#111813] dark:text-white">Hapus sidik jari lama di HP?</span>
            </div>
            <span
                class="material-symbols-outlined text-gray-400 group-open:rotate-180 transition-transform">expand_more</span>
        </summary>
        <div class="px-2.5 pb-2.5 text-[11px] text-gray-600 dark:text-gray-400 leading-relaxed space-y-2">
            <p>Jika muncul pilihan sandi/sidik jari lama yang sudah tidak terpakai, Anda bisa menghapusnya dari
                pengaturan HP:</p>

            <div class="bg-gray-50 dark:bg-gray-900/50 p-2.5 rounded-xl border border-gray-100 dark:border-gray-700">
                <strong class="block text-gray-800 dark:text-gray-200 mb-1">🤖 Android (Google Chrome)</strong>
                <p class="text-[9px] text-gray-500 mb-1.5">Jika tidak ketemu di Pengaturan HP, coba cek di Pengaturan
                    Chrome:</p>
                <ol class="list-decimal list-inside text-[10px] space-y-1">
                    <li>Buka aplikasi <strong>Chrome</strong> di HP.</li>
                    <li>Klik titik tiga di pojok kanan atas > <strong>Setelan (Settings)</strong>.</li>
                    <li>Pilih <strong>Pengelola Kata Sandi</strong>.</li>
                    <li>Jika masih tidak ada, coba ketik di address bar: <br>
                        <code class="bg-gray-200 px-1 rounded text-[9px]">chrome://settings/passkeys</code>
                    </li>
                    <li>Hapus kunci sandi (passkey) yang tidak diinginkan.</li>
                </ol>
            </div>

            <div class="bg-gray-50 dark:bg-gray-900/50 p-2.5 rounded-xl border border-gray-100 dark:border-gray-700">
                <strong class="block text-gray-800 dark:text-gray-200 mb-1">🍎 iOS (iPhone/iPad)</strong>
                <ol class="list-decimal list-inside text-[10px] space-y-1">
                    <li>Buka <strong>Pengaturan (Settings)</strong></li>
                    <li>Pilih menu <strong>Kata Sandi (Passwords)</strong></li>
                    <li>Cari "TPQ" atau alamat website ini</li>
                    <li>Geser ke kiri pada akun lama, lalu klik <strong>Hapus</strong>.</li>
                </ol>
            </div>
            <div class="bg-gray-50 dark:bg-gray-900/50 p-2.5 rounded-xl border border-gray-100 dark:border-gray-700">
                <strong class="block text-gray-800 dark:text-gray-200 mb-1">💻 Windows (Laptop/PC)</strong>
                <ol class="list-decimal list-inside text-[10px] space-y-1">
                    <li>Buka <strong>Settings</strong> di Windows.</li>
                    <li>Pilih menu <strong>Accounts</strong> > <strong>Sign-in options</strong>.</li>
                    <li>Klik <strong>Security Key</strong> (atau Kunci Keamanan) > <strong>Manage</strong>.</li>
                    <li>Pilih <strong>Manage</strong> (Masukkan PIN/Sidik jari jika diminta).</li>
                    <li>Pilih kredensial "TPQ" dan klik <strong>Delete/Remove</strong>.</li>
                </ol>
            </div>
        </div>
    </details>
</div>

{{-- Contact Support --}}
<div class="bg-gradient-to-br from-primary/20 to-primary/5 rounded-xl p-3 border border-primary/20">
    <div class="flex items-start gap-2.5">
        <div class="shrink-0 size-8 rounded-lg bg-primary flex items-center justify-center text-[#102216]">
            <span class="material-symbols-outlined text-[18px]">support_agent</span>
        </div>
        <div>
            <h4 class="font-bold text-xs text-[#111813] dark:text-white">Butuh Bantuan Lain?</h4>
            <p class="text-[10px] text-gray-600 dark:text-gray-400 mt-0.5 mb-1.5">Tim kami siap membantu Anda</p>
            <a href="https://wa.me/6281234567890" target="_blank"
                class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-primary text-[#102216] text-[10px] font-bold rounded-lg hover:shadow-lg hover:shadow-primary/25 transition">
                <span class="material-symbols-outlined text-[14px]">chat</span>
                Hubungi via WhatsApp
            </a>
        </div>
    </div>
</div>

@endsection
