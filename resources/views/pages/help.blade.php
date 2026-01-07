@extends('layouts.mobile')

@section('title', 'Bantuan')

@section('header')
<header
    class="sticky top-0 z-10 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md border-b border-gray-100 dark:border-gray-800">
    <div class="flex items-center gap-3 px-5 py-4">
        <a href="{{ url()->previous() }}"
            class="p-2 -ml-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h2 class="text-xl font-bold">Bantuan</h2>
    </div>
</header>
@endsection

@section('content')

{{-- Search --}}
<div class="relative">
    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">search</span>
    <input type="text" placeholder="Cari pertanyaan..."
        class="w-full pl-12 pr-4 py-3 rounded-2xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 text-sm focus:ring-2 focus:ring-primary/50" />
</div>

{{-- FAQ Categories --}}
<div class="flex flex-wrap gap-2">
    <button class="px-4 py-2 rounded-full bg-primary text-[#102216] text-sm font-semibold">Semua</button>
    <button
        class="px-4 py-2 rounded-full bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-sm font-medium border border-gray-200 dark:border-gray-700">Presensi</button>
    <button
        class="px-4 py-2 rounded-full bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-sm font-medium border border-gray-200 dark:border-gray-700">Hafalan</button>
    <button
        class="px-4 py-2 rounded-full bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-sm font-medium border border-gray-200 dark:border-gray-700">Akun</button>
</div>

{{-- FAQ List --}}
<div class="flex flex-col gap-3">
    {{-- FAQ Item 1 --}}
    <details
        class="group bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
        <summary class="flex items-center justify-between p-4 cursor-pointer">
            <div class="flex items-center gap-3">
                <div class="shrink-0 size-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined">location_on</span>
                </div>
                <span class="font-semibold text-[#111813] dark:text-white">Bagaimana cara presensi?</span>
            </div>
            <span
                class="material-symbols-outlined text-gray-400 group-open:rotate-180 transition-transform">expand_more</span>
        </summary>
        <div class="px-4 pb-4 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
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
        <summary class="flex items-center justify-between p-4 cursor-pointer">
            <div class="flex items-center gap-3">
                <div
                    class="shrink-0 size-10 rounded-xl bg-orange-50 dark:bg-orange-900/30 flex items-center justify-center text-orange-500">
                    <span class="material-symbols-outlined">menu_book</span>
                </div>
                <span class="font-semibold text-[#111813] dark:text-white">Cara melihat riwayat hafalan?</span>
            </div>
            <span
                class="material-symbols-outlined text-gray-400 group-open:rotate-180 transition-transform">expand_more</span>
        </summary>
        <div class="px-4 pb-4 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
            Buka menu "Riwayat" di bottom navigation. Di sana Anda bisa melihat semua setoran hafalan beserta nilai dan
            catatan dari ustadz.
        </div>
    </details>

    {{-- FAQ Item 3 --}}
    <details
        class="group bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
        <summary class="flex items-center justify-between p-4 cursor-pointer">
            <div class="flex items-center gap-3">
                <div
                    class="shrink-0 size-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-500">
                    <span class="material-symbols-outlined">lock</span>
                </div>
                <span class="font-semibold text-[#111813] dark:text-white">Lupa password, bagaimana?</span>
            </div>
            <span
                class="material-symbols-outlined text-gray-400 group-open:rotate-180 transition-transform">expand_more</span>
        </summary>
        <div class="px-4 pb-4 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
            Hubungi Admin TPQ untuk reset password Anda. Siapkan NIS/Email yang terdaftar sebagai verifikasi.
        </div>
    </details>

    {{-- FAQ Item 4 --}}
    <details
        class="group bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
        <summary class="flex items-center justify-between p-4 cursor-pointer">
            <div class="flex items-center gap-3">
                <div
                    class="shrink-0 size-10 rounded-xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center text-purple-500">
                    <span class="material-symbols-outlined">notifications</span>
                </div>
                <span class="font-semibold text-[#111813] dark:text-white">Notifikasi tidak muncul?</span>
            </div>
            <span
                class="material-symbols-outlined text-gray-400 group-open:rotate-180 transition-transform">expand_more</span>
        </summary>
        <div class="px-4 pb-4 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
            Pastikan notifikasi diaktifkan di Profil > Notifikasi. Juga cek pengaturan notifikasi di browser/perangkat
            Anda.
        </div>
    </details>
</div>

{{-- Contact Support --}}
<div class="bg-gradient-to-br from-primary/20 to-primary/5 rounded-2xl p-5 border border-primary/20">
    <div class="flex items-start gap-4">
        <div class="shrink-0 size-12 rounded-xl bg-primary flex items-center justify-center text-[#102216]">
            <span class="material-symbols-outlined">support_agent</span>
        </div>
        <div>
            <h4 class="font-bold text-[#111813] dark:text-white">Butuh Bantuan Lain?</h4>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 mb-3">Tim kami siap membantu Anda</p>
            <a href="https://wa.me/6281234567890" target="_blank"
                class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-[#102216] text-sm font-bold rounded-xl hover:shadow-lg hover:shadow-primary/25 transition">
                <span class="material-symbols-outlined" style="font-size: 18px;">chat</span>
                Hubungi via WhatsApp
            </a>
        </div>
    </div>
</div>

@endsection
