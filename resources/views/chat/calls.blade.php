@extends('layouts.mobile')

@section('title', 'Panggilan')

@section('header')
<header class="bg-blue-600 px-6 pt-6 pb-6 shadow-lg relative overflow-hidden">
    {{-- Decorative blobs --}}
    <div class="absolute top-[-40px] right-[-40px] w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-[-20px] left-[-20px] w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>

    <div class="relative z-10">
        <div class="flex items-center justify-center mb-4 relative">
            <h1 class="text-lg font-bold text-white">Riwayat Panggilan</h1>
            <div class="absolute right-0 flex gap-2">
                <button class="text-white/80 hover:text-white p-1.5 rounded-lg hover:bg-white/10 transition">
                    <span class="material-symbols-outlined text-lg">add_call</span>
                </button>
            </div>
        </div>
        <div class="relative w-full mt-2">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-white/70">
                <span class="material-symbols-outlined text-xl">search</span>
            </div>
            <input id="searchInput" onkeyup="filterCalls()"
                class="block w-full pl-10 pr-4 py-3 bg-white/15 backdrop-blur-sm border-none rounded-xl text-white placeholder-white/60 focus:ring-2 focus:ring-white/30 text-sm font-medium"
                placeholder="Cari Riwayat Panggilan..." type="text" />
        </div>
    </div>
</header>
@endsection

@section('content')

{{-- Calls List --}}
<div id="callsList" class="flex flex-col gap-3 -mt-2 pb-24">

    <!-- Call Item: Incoming (Ustadz) -->
    <div
        class="bg-white dark:bg-slate-800 p-4 rounded-xl flex items-center justify-between shadow-sm border border-slate-100 dark:border-slate-700 transition-transform active:scale-[0.98]">
        <div class="flex items-center gap-4">
            <div class="relative">
                <div class="w-14 h-14 rounded-full bg-slate-200 bg-cover bg-center shrink-0"
                    style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBlD4LRfLm_c3zhjI2cCkFJaOUu7Usz8rxG39e5d4wUJqkqqFmqyZvXFI4qNTFLgux-dWZrbbGsQJ27jA-LGjaudkhtPoZydgg5cNnDBtb679kABVRKos-igW1ePJwR6L2SdOhTfWGj_8nHbALC6cyEbzIy56u_-91EkSx1dKRq05o2bQK6-lSMtPQP-z4AtrOzCZtUxscwL-HsHtiacK5-Z0Epxa5i5Que-JeQ_tgfavCCnapAWwXa_nm2Vxl3t1FYbMnK8B3Pvf2_')">
                </div>
            </div>
            <div>
                <h3 class="font-bold text-slate-900 dark:text-slate-100 text-[15px]">Ustadz Ahmad</h3>
                <div class="flex items-center gap-1 mt-0.5">
                    <span class="material-symbols-outlined text-green-500 text-[16px] font-bold">call_received</span>
                    <p class="text-[12px] text-slate-500 dark:text-slate-400">Masuk, 10:30 • Hari ini</p>
                </div>
            </div>
        </div>
        <button class="p-2 text-blue-600 hover:bg-blue-600/10 rounded-full transition-colors shrink-0">
            <span class="material-symbols-outlined text-[24px]">call</span>
        </button>
    </div>

    <!-- Call Item: Missed (Santri) -->
    <div
        class="bg-white dark:bg-slate-800 p-4 rounded-xl flex items-center justify-between shadow-sm border border-slate-100 dark:border-slate-700 transition-transform active:scale-[0.98]">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-slate-200 bg-cover bg-center border-2 border-red-100 shrink-0"
                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAQKOXdnZXDPivGqfrTmihikua1MiumFezs0S6nRS4s5QajPGUv78gBrXdmwLYV7vtxwiNu7Q2IsB9f3w3-nMyEyuidZbLMZ-6mZZxjsaeNzC0FCd-ACOtjG5wpfgO96AtgJEumFs8VSmYntlcAwfQthB88OnpuS_dxttypW8bTk8AkFDWPb7zDpBMO9Sz-42TcMP_8pGmtxxuoycpNcjF7fQCDTaRiaSdu8OBtzjDALnAOzDgIM0sPpoyxyPS14MG1LC4f_Hmel6H0')">
            </div>
            <div>
                <h3 class="font-bold text-red-500 text-[15px]">Siti Aminah</h3>
                <div class="flex items-center gap-1 mt-0.5">
                    <span class="material-symbols-outlined text-red-500 text-[16px] font-bold">call_missed</span>
                    <p class="text-[12px] text-red-400">Tak terjawab, 08:45</p>
                </div>
            </div>
        </div>
        <button class="p-2 text-blue-600 hover:bg-blue-600/10 rounded-full transition-colors shrink-0">
            <span class="material-symbols-outlined text-[24px]">videocam</span>
        </button>
    </div>

    <!-- Call Item: Outgoing -->
    <div
        class="bg-white dark:bg-slate-800 p-4 rounded-xl flex items-center justify-between shadow-sm border border-slate-100 dark:border-slate-700 transition-transform active:scale-[0.98]">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-slate-200 bg-cover bg-center shrink-0"
                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBPTP_qmxOlwW5YgSq85pGDFcxxCZUdbsyS4aLcJxz8EsMqxjsj_d4uRTGUdNxWAiYp1vxqDLd5c8KfvFMeIkanHfX4IARFXfwpWXC5msL5kPvc8aDFTzeHQ-IhGwXSSbG3KYpjAiDp6j3sOFOhuF2KvBmERGw3_g6OeVAdofSFnn4CiEYPphrf8pt-YFaTqcjEOyO5BwpLpW5voGoMDopzSYdPJLpGMs0p0pAXK2F5wKdxwozfPaBr1qdp3u38f_38AmIAHJq7dAFI')">
            </div>
            <div>
                <h3 class="font-bold text-slate-900 dark:text-slate-100 text-[15px]">Ustadzah Fatimah</h3>
                <div class="flex items-center gap-1 mt-0.5">
                    <span class="material-symbols-outlined text-slate-400 text-[16px] font-bold">call_made</span>
                    <p class="text-[12px] text-slate-500 dark:text-slate-400">Keluar, Kemarin 19:20</p>
                </div>
            </div>
        </div>
        <button class="p-2 text-blue-600 hover:bg-blue-600/10 rounded-full transition-colors shrink-0">
            <span class="material-symbols-outlined text-[24px]">call</span>
        </button>
    </div>

    <!-- Call Item: Video Incoming -->
    <div
        class="bg-white dark:bg-slate-800 p-4 rounded-xl flex items-center justify-between shadow-sm border border-slate-100 dark:border-slate-700 transition-transform active:scale-[0.98]">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-slate-200 bg-cover bg-center shrink-0"
                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCIS6-sje8efdRQhPbFTcdDHT5rL1g7ujSCP5B3rAfpULwVvPtt5hkCz25hTizACwX-R4B7BNrinXqhBcGoDmdTGmq3DxHaSswFON3BAlmwiVlquntoXGPtAXli1nowXbUVtIo7spg0VOt5kPJhsX54V2iddGGXtMeNKtdG-1y0R5JXwKuiE_stsQ3_VWz1NO_7GmwP4ZCnH-34syc8KR3AELA2OCeoBZmLD7N1roYTayTKFXsxzQGoeWBVjaoTqKhSAiPBomRe0X4v')">
            </div>
            <div>
                <h3 class="font-bold text-slate-900 dark:text-slate-100 text-[15px]">Muhammad Rizky</h3>
                <div class="flex items-center gap-1 mt-0.5">
                    <span class="material-symbols-outlined text-green-500 text-[16px] font-bold">videocam</span>
                    <p class="text-[12px] text-slate-500 dark:text-slate-400">Masuk, Kemarin 14:15</p>
                </div>
            </div>
        </div>
        <button class="p-2 text-blue-600 hover:bg-blue-600/10 rounded-full transition-colors shrink-0">
            <span class="material-symbols-outlined text-[24px]">videocam</span>
        </button>
    </div>

    <!-- Call Item: Missed -->
    <div
        class="bg-white dark:bg-slate-800 p-4 rounded-xl flex items-center justify-between shadow-sm border border-slate-100 dark:border-slate-700 transition-transform active:scale-[0.98]">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-slate-200 bg-cover bg-center border-2 border-red-100 shrink-0"
                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuARkmCsUqE_BAL2sj7qc20st4ltU5XvMc__vxC41EuZ-u-RSGIynYVnCYJWrdluh_MOSG_NQGhXmdcoXLOvpaBsSD0ElsueKDXmwE1eMrMfVOEL_GTaOWErWu3KVA5XqzSo_9YEYEG_MMiGoQ7E9vqnxyC2QorgPlAn0nIgGAUv-4dBX-DKYOitgUhEs3lgrm_Blb1OLwH24lneSjH-pjy-3HjFjF3elxPnx2-j-_OPuEG3WOY_Mw6dNW1IVDrNW3SmcCph8QN2OkGp')">
            </div>
            <div>
                <h3 class="font-bold text-red-500 text-[15px]">Zahra Az-Zahra</h3>
                <div class="flex items-center gap-1 mt-0.5">
                    <span class="material-symbols-outlined text-red-500 text-[16px] font-bold">call_missed</span>
                    <p class="text-[12px] text-red-400">Tak terjawab, 2 hari yang lalu</p>
                </div>
            </div>
        </div>
        <button class="p-2 text-blue-600 hover:bg-blue-600/10 rounded-full transition-colors shrink-0">
            <span class="material-symbols-outlined text-[24px]">call</span>
        </button>
    </div>

</div>

{{-- FAB --}}
<button
    class="fixed bottom-24 right-6 size-11 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg shadow-blue-600/30 hover:shadow-xl hover:bg-blue-700 transition-all active:scale-95 z-40">
    <span class="material-symbols-outlined text-xl">add_ic_call</span>
</button>

@endsection

@section('bottom-nav')
<nav class="fixed bottom-0 left-0 right-0 w-full max-w-md mx-auto z-50">
    <div
        class="bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 px-6 pt-3 pb-3 rounded-t-2xl shadow-[0_-8px_30px_rgba(0,0,0,0.08)]">
        <div class="flex justify-around items-center">
            {{-- Chat --}}
            <a class="flex flex-col items-center gap-1 py-1 px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all"
                href="{{ route('chat.index') }}">
                <span class="material-symbols-outlined">chat</span>
                <span class="text-[10px] font-medium">Chat</span>
            </a>
            {{-- Status --}}
            <a class="flex flex-col items-center gap-1 py-1 px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all"
                href="#">
                <span class="material-symbols-outlined">track_changes</span>
                <span class="text-[10px] font-medium">Status</span>
            </a>
            {{-- Komunitas --}}
            <a class="flex flex-col items-center gap-1 py-1 px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all"
                href="{{ route('chat.group') }}">
                <span class="material-symbols-outlined">groups</span>
                <span class="text-[10px] font-medium">Grup</span>
            </a>
            {{-- Panggilan (Active) --}}
            <a class="flex flex-col items-center gap-1 py-1 px-3 text-blue-600 transition-all"
                href="{{ route('chat.calls') }}">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">call</span>
                <span class="text-[10px] font-bold">Panggilan</span>
            </a>
        </div>

    </div>
</nav>
@endsection

@push('scripts')
<script>
    function filterCalls() {
        // Implement filtering when there are actual call items
    }
</script>
@endpush
