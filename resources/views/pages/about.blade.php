@extends('layouts.mobile')

@section('title', 'Tentang Aplikasi')

@php
    $hideBottomNav = true;
@endphp

@section('header')
<header
    class="sticky top-0 z-10 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md border-b border-gray-100 dark:border-gray-800">
    <div class="flex items-center justify-center gap-3 px-5 py-4">
        <h2 class="text-xl font-bold">Tentang Aplikasi</h2>
    </div>
</header>
@endsection

@section('content')

{{-- App Info Card --}}
<div
    class="bg-white dark:bg-gray-800 rounded-3xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm text-center">
    {{-- Logo --}}
    <div class="mx-auto -mb-4 size-36">
        <img src="{{ asset('logo-tpq.png') }}" alt="Logo TPQ" class="w-full h-full object-contain">
    </div>

    <h1 class="text-xl font-bold text-[#111813] dark:text-white">TPQ Daarul Gusmik Al-Hufadz</h1>
    <p class="text-gray-500 mt-1 text-sm">Tahsin - Tahfidz - Tafsir</p>

    <div
        class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-semibold">
        <span class="material-symbols-outlined" style="font-size: 16px;">apps</span>
        Versi {{ config('app.version', '1.0.0') }}
    </div>
</div>

{{-- Description --}}
<div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm">
    <h3 class="font-bold text-[#111813] dark:text-white mb-3">Tentang</h3>
    <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
        TPQ Digital adalah aplikasi manajemen Taman Pendidikan Al-Quran (TPQ) Daarul Gusmikalhufadz yang memudahkan
        proses presensi, pencatatan hafalan, dan komunikasi antara santri, ustadz, dan admin.
    </p>
</div>

{{-- Features --}}
<div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm">
    <h3 class="font-bold text-[#111813] dark:text-white mb-4">Fitur Utama</h3>
    <div class="grid grid-cols-2 gap-3">
        <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
            <span class="material-symbols-outlined text-primary">how_to_reg</span>
            <span class="text-sm font-medium">Presensi GPS</span>
        </div>
        <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
            <span class="material-symbols-outlined text-orange-500">menu_book</span>
            <span class="text-sm font-medium">Setoran Hafalan</span>
        </div>
        <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
            <span class="material-symbols-outlined text-blue-500">chat</span>
            <span class="text-sm font-medium">Chat Ustadz</span>
        </div>
        <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
            <span class="material-symbols-outlined text-purple-500">notifications</span>
            <span class="text-sm font-medium">Notifikasi</span>
        </div>
    </div>
</div>

{{-- Developer Info --}}
<div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 shadow-sm">
    <h3 class="font-bold text-[#111813] dark:text-white mb-3">Pengembang</h3>
    <div class="flex items-center gap-4">
        <div
            class="size-12 rounded-full bg-gradient-to-br from-primary to-primary-dark flex items-center justify-center text-[#102216] font-bold text-lg">
            M
        </div>
        <div>
            <h4 class="font-semibold text-[#111813] dark:text-white">MUNAWIR</h4>
            <p class="text-sm text-gray-500">Developer</p>
        </div>
    </div>
</div>

{{-- Links --}}
<div class="flex flex-col gap-2">
    <a href="#"
        class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-primary/30 transition">
        <span class="material-symbols-outlined text-gray-500">description</span>
        <span class="flex-1 font-medium">Syarat & Ketentuan</span>
        <span class="material-symbols-outlined text-gray-400">chevron_right</span>
    </a>
    <a href="#"
        class="flex items-center gap-4 p-4 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 hover:border-primary/30 transition">
        <span class="material-symbols-outlined text-gray-500">privacy_tip</span>
        <span class="flex-1 font-medium">Kebijakan Privasi</span>
        <span class="material-symbols-outlined text-gray-400">chevron_right</span>
    </a>
</div>

{{-- Copyright --}}
<p class="text-center text-xs text-gray-400">
    © {{ date('Y') }} TPQ Daarul Gusmikalhufadz<br>
    All rights reserved.
</p>

@endsection
