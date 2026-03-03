@extends('layouts.mobile')

@section('title', 'Status')

@section('header')
<header class="bg-blue-600 px-4 pt-3 pb-3 shadow-lg relative overflow-hidden">
    {{-- Decorative blobs --}}
    <div class="absolute top-[-40px] right-[-40px] w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-[-20px] left-[-20px] w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>

    <div class="relative z-10">
        <div class="flex items-center justify-between relative">
            <h1 class="text-base font-bold text-white">Status</h1>
            <div class="flex gap-2">
                <button class="text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/10 transition">
                    <span class="material-symbols-outlined text-[20px]">search</span>
                </button>
                <button class="text-white/80 hover:text-white p-1 rounded-lg hover:bg-white/10 transition">
                    <span class="material-symbols-outlined text-[20px]">more_vert</span>
                </button>
            </div>
        </div>
    </div>
</header>
@endsection

@section('content')
<style>
    .status-ring {
        padding: 2px;
        background: conic-gradient(from 0deg, #13ecb6 0% 25%, transparent 25% 30%, #13ecb6 30% 60%, transparent 60% 65%, #13ecb6 65% 100%);
    }

    .status-ring-single {
        padding: 2px;
        background: #13ecb6;
    }
</style>

<!-- Main Content -->
<div class="relative flex-1 overflow-y-auto pb-24">
    <!-- My Status Section -->
    <div class="px-5 py-3.5 bg-white dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
        <div class="flex items-center gap-3 cursor-pointer">
            <div class="relative">
                <div class="h-[42px] w-[42px] rounded-full bg-slate-200 dark:bg-slate-700 bg-cover bg-center shrink-0"
                    data-alt="User profile picture for status update"
                    style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuA_JAQ8paJ_bDoyrDwH40AyK9eTz8G55aeKjywkNuN_Lom33COQOpVVV78S7F3XQto1ysl6vsBvxmjO4XhaY-9xByTJ2ENex0b63MQJEoD06zfHIr1RYyK5ZjkRPMve7LFpgB3prKHmrJujfhMFvT_ozq6cbm0G_crTbtD2jYYWagisxQUNIlB8OorobQmmn4XEUtrYnFeYaRAlSnJej5jfiWjy2jsNsVd9dNDjQ0X3h02YzMUZFvXQy08zrMUFla2eKeoP_aXfeBEj')">
                </div>
                <div
                    class="absolute bottom-0 right-[-2px] bg-blue-600 border-[1.5px] border-white dark:border-gray-800 rounded-full h-[18px] w-[18px] flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-[11px] font-bold mt-[1px]">add</span>
                </div>
            </div>
            <div class="flex flex-col">
                <h2 class="font-bold text-[12.5px] text-gray-900 dark:text-gray-100">Status Saya</h2>
                <p class="text-[10.5px] text-gray-500 dark:text-gray-400 mt-0.5">Ketuk untuk menambahkan pembaruan
                    status
                </p>
            </div>
        </div>
    </div>

    <!-- Recent Updates Section -->
    <div class="mt-2">
        <h3 class="text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2 px-5">Pembaruan
            Terbaru</h3>

        <div class="flex flex-col">
            <!-- Status Item 1 -->
            <div
                class="flex items-center gap-3 px-5 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors cursor-pointer border-b border-gray-100 dark:border-gray-800">
                <div class="status-ring rounded-full p-[1.5px] shrink-0">
                    <div class="h-[38px] w-[38px] rounded-full border-2 border-white dark:border-gray-900 bg-slate-200 dark:bg-slate-700 bg-cover bg-center shrink-0"
                        data-alt="Ustadz Ahmad profile picture with status rings"
                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDVwl14uHtBoVkaNZdO9JU_JVuTpK_PAtPiVRErBguEEbxypa53OTqsO5RvvLmzBbOyRvlMneFDUkA_JLRvhfVeyxKtAc3HMCe7nTcZTRoUa-t1DlwhyQxMwd4EnUhiGEvvEsxg1D1_2ucTYx0Aej3TkOQ6i_xmSdlhMT1xdDY49KgRO2JgNKdiytdDh-FUhvjgnD3wR7--m9v3ZJFidKqIYLEDl7ccdlJb09jY1sRVK8aztUTqxjPKOn3V0kRjNBCOFdRWGx4Z8qzk')">
                    </div>
                </div>
                <div class="flex flex-col flex-1 min-w-0">
                    <h4 class="font-bold text-[12.5px] text-gray-900 dark:text-gray-100 truncate">Ustadz Ahmad</h4>
                    <p class="text-[10.5px] text-gray-500 dark:text-gray-400 mt-0.5 truncate">Baru saja</p>
                </div>
            </div>

            <!-- Status Item 2 -->
            <div
                class="flex items-center gap-3 px-5 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors cursor-pointer border-b border-gray-100 dark:border-gray-800">
                <div class="status-ring-single rounded-full p-[1.5px] shrink-0">
                    <div class="h-[38px] w-[38px] rounded-full border-2 border-white dark:border-gray-900 bg-slate-200 dark:bg-slate-700 bg-cover bg-center shrink-0"
                        data-alt="Ustadzah Siti profile picture with status ring"
                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAAfXEiQrArkqfTzbuKbjAmvZTuuW6QrjmF0QmnHYIRltMmM7eOW8dL22-qZpRQK1RV6eWZEo9eidb3wyJR2P1rqkaLIr5xAd-t_lRTJbk7b78t9jRILpbyLwLbVceveAMUIHGDpzvm4zwxG_kMBExKf2M31yA1nkttYHGNAE78iyLaziTUfQsu8PEDwhLZKqE8hwtc0gF6BMNDSe755x3cBs6rfN65v4mFkc1z0MQa5M0pU8mXhyqDc0NWMMwV-22-4vCU0ATWciEE')">
                    </div>
                </div>
                <div class="flex flex-col flex-1 min-w-0">
                    <h4 class="font-bold text-[12.5px] text-gray-900 dark:text-gray-100 truncate">Ustadzah Siti</h4>
                    <p class="text-[10.5px] text-gray-500 dark:text-gray-400 mt-0.5 truncate">15 menit yang lalu</p>
                </div>
            </div>

            <!-- Status Item 3 -->
            <div
                class="flex items-center gap-3 px-5 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors cursor-pointer border-b border-gray-100 dark:border-gray-800">
                <div class="status-ring rounded-full p-[1.5px] shrink-0">
                    <div class="h-[38px] w-[38px] rounded-full border-2 border-white dark:border-gray-900 bg-slate-200 dark:bg-slate-700 bg-cover bg-center shrink-0"
                        data-alt="Santri Raihan profile picture with status rings"
                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBjLXAcgHXEBhmE4eTK8sh8bo8rWe7pX_6Nrsl658hjiCYaUOqbDqmuwfnu4Uy6amiEmHaNnbuVYFFzVDgs9nqbDfC3sbd1KSAwsly6UFtG_L_rR_gKlBDwWQELkGjXwYRq_SVCdm-cYYjM1UpEFi64nlZRQJngGfSFlzsvP3EBdcX6xORHe_u49by8GwFk76bF0YAI37OZrNkcDc8VA55L4ogwWa5sLarquIznu4EJr6BCbM9P5B7AmPep49MH_t2PBJnon_cUhlCm')">
                    </div>
                </div>
                <div class="flex flex-col flex-1 min-w-0">
                    <h4 class="font-bold text-[12.5px] text-gray-900 dark:text-gray-100 truncate">Raihan (Santri)</h4>
                    <p class="text-[10.5px] text-gray-500 dark:text-gray-400 mt-0.5 truncate">1 jam yang lalu</p>
                </div>
            </div>

            <!-- Status Item 4 -->
            <div
                class="flex items-center gap-3 px-5 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors cursor-pointer border-b border-gray-100 dark:border-gray-800">
                <div class="status-ring-single rounded-full p-[1.5px] shrink-0">
                    <div class="h-[38px] w-[38px] rounded-full border-2 border-white dark:border-gray-900 bg-slate-200 dark:bg-slate-700 bg-cover bg-center shrink-0"
                        data-alt="Walid Santri profile picture with status ring"
                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDLb9Wr1gepdhRq-2jeJ21CqP03ZqC6Twq6C6Xe4nYNAvGXhgWarv9HSppoXvGVScaJBdeRelRelJVbs7S9Z5ORmcmXYceRzhyM2XkKusTf_K-GdcTxpP8LM2q3u92HUpiRHXbd64vhdarD_bb9qOos28DRYat0eoaepdpJES4rUxUV7VtSVdLnRT32myGGlJFJAa2xfPobETm5DPlo_bGIKQE8KVVo-_KNBdJkoFAdUS2w93AM-J8DgRYdSSEw8yHq0LF8Gvr0gcjg')">
                    </div>
                </div>
                <div class="flex flex-col flex-1 min-w-0">
                    <h4 class="font-bold text-[12.5px] text-gray-900 dark:text-gray-100 truncate">Bapak Furqon</h4>
                    <p class="text-[10.5px] text-gray-500 dark:text-gray-400 mt-0.5 truncate">2 jam yang lalu</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Action Button -->
<div class="fixed bottom-24 right-6 flex flex-col gap-4 items-center z-40">
    <button
        class="bg-white dark:bg-[#1a2e28] text-slate-600 dark:text-slate-300 shadow-md p-3.5 flex items-center justify-center rounded-full hover:scale-105 active:scale-95 transition-transform">
        <span class="material-symbols-outlined text-[24px]">edit</span>
    </button>
    <button
        class="bg-[#13ecb6] text-white shadow-lg p-3.5 flex items-center justify-center rounded-full hover:scale-105 active:scale-95 transition-transform">
        <span class="material-symbols-outlined text-[24px]">photo_camera</span>
    </button>
</div>
@endsection

@section('bottom-nav')
<nav class="fixed bottom-0 left-0 right-0 w-full max-w-md mx-auto z-50">
    <div
        class="bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 px-6 pt-2 pb-2 rounded-t-2xl shadow-[0_-8px_30px_rgba(0,0,0,0.08)]">
        <div class="flex justify-around items-center">
            {{-- Chat --}}
            <a class="flex flex-col items-center gap-0.5 py-1 px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all"
                href="{{ route('chat.index') }}">
                <span class="material-symbols-outlined text-[22px]">chat</span>
                <span class="text-[10px] font-medium">Chat</span>
            </a>
            {{-- Status (Active) --}}
            <a class="flex flex-col items-center gap-0.5 py-1 px-3 text-[#13ecb6] transition-all relative"
                href="{{ route('chat.status') }}">
                <span class="material-symbols-outlined fill-1 text-[22px]">donut_large</span>
                <span class="text-[10px] font-bold">Status</span>
                <div class="absolute -top-0.5 w-1 h-1 bg-[#13ecb6] rounded-full"></div>
            </a>
            {{-- Komunitas --}}
            <a class="flex flex-col items-center gap-0.5 py-1 px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all"
                href="{{ route('chat.group') }}">
                <span class="material-symbols-outlined text-[22px]">groups</span>
                <span class="text-[10px] font-medium">Grup</span>
            </a>
            {{-- Panggilan --}}
            <a class="flex flex-col items-center gap-0.5 py-1 px-3 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-all"
                href="{{ route('chat.calls') }}">
                <span class="material-symbols-outlined text-[22px]">call</span>
                <span class="text-[10px] font-medium">Panggilan</span>
            </a>
        </div>
    </div>
</nav>
@endsection
