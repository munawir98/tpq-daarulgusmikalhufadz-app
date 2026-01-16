<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Kirim Notifikasi - TPQ Daarul Gusmik</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#0066FF",
                        "whatsapp": "#25D366",
                        "background": "#FFFFFF",
                        "surface": "#F8FAFC",
                        "accent-blue": "#E0E7FF"
                    },
                    fontFamily: {
                        "display": ["Lexend", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        body {
            font-family: 'Lexend', sans-serif;
            -webkit-tap-highlight-color: transparent;
            background-color: #FFFFFF;
        }

        .ios-blur {
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-white text-slate-900 min-h-screen flex flex-col">
    <!-- Form Wrapper -->
    <form action="{{ route('ustadz.broadcast.store') }}" method="POST" class="flex flex-col flex-1 h-full">
        @csrf
        <header class="sticky top-0 z-50 bg-white/90 ios-blur border-b border-slate-100">
            <div class="flex items-center p-4 h-16 max-w-md mx-auto w-full">
                <a href="{{ url()->previous() }}"
                    class="flex items-center justify-center p-2 -ml-2 rounded-full hover:bg-slate-100 transition-colors">
                    <span class="material-symbols-outlined text-2xl text-primary">arrow_back_ios_new</span>
                </a>
                <h1 class="flex-1 text-center text-lg font-bold tracking-tight mr-8 text-primary">Kirim Notifikasi</h1>
            </div>
        </header>

        <main class="flex-1 max-w-md mx-auto w-full pb-32">
            {{-- Success/Error Messages --}}
            @if(session('success'))
            <div class="p-4 mx-4 mt-4 bg-green-50 border border-green-200 rounded-xl text-green-600 text-sm">
                {{ session('success') }}
            </div>
            @endif
            @if($errors->any())
            <div class="p-4 mx-4 mt-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm">
                {{ $errors->first() }}
            </div>
            @endif

            <section class="p-4">
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            {{-- Placeholder Avatar --}}
                            <div
                                class="w-16 h-16 rounded-full bg-cover bg-center border-2 border-primary/20 flex items-center justify-center bg-gray-200 text-gray-500">
                                <span class="material-symbols-outlined text-3xl">groups</span>
                            </div>
                            <div
                                class="absolute -bottom-1 -right-1 bg-primary text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white">
                                TARGET</div>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-lg font-bold leading-none text-slate-900">Broadcast</h2>
                            <div class="mt-2">
                                <select name="target"
                                    class="w-full text-sm rounded-lg border-gray-300 focus:border-primary focus:ring-primary p-1.5 bg-white">
                                    <option value="all_santri">Semua Santri</option>
                                    <option value="all_ustadz">Semua Ustadz</option>
                                    <option value="all_users">Semua Pengguna</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mt-2">
                <div class="px-4 mb-3">
                    <label class="text-xs font-bold uppercase tracking-wider text-slate-400">Judul Pesan</label>
                </div>
                <div class="px-4">
                    <input type="text" name="title"
                        class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm p-3"
                        placeholder="Judul Pengumuman" required>
                </div>
            </section>

            <section class="p-4 mt-2">
                <div class="mb-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Isi Pesan</h3>
                </div>
                <div
                    class="relative bg-white border border-slate-200 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-primary/20 focus-within:border-primary transition-all">
                    <textarea name="content"
                        class="w-full bg-transparent border-none focus:ring-0 text-slate-700 p-4 min-h-[200px] text-base leading-relaxed"
                        placeholder="Tulis pesan Anda di sini..." required></textarea>
                </div>
            </section>

            <section class="px-4 py-2">
                <div class="flex gap-3 bg-blue-50 border border-blue-100 p-4 rounded-xl">
                    <span class="material-symbols-outlined text-blue-500 text-xl shrink-0">info</span>
                    <p class="text-xs text-blue-700 leading-relaxed font-medium">
                        Pesan akan dikirim melalui sistem notifikasi aplikasi ke target yang dipilih.
                    </p>
                </div>
            </section>
        </main>

        <footer class="fixed bottom-0 left-0 right-0 p-4 bg-white/90 ios-blur border-t border-slate-100 z-50">
            <div class="max-w-md mx-auto flex flex-col gap-3">
                <button type="submit"
                    class="w-full h-14 bg-primary hover:brightness-105 active:scale-[0.98] transition-all rounded-xl flex items-center justify-center gap-2 text-white font-bold text-lg shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined">notifications_active</span>
                    Kirim Notifikasi
                </button>
            </div>
        </footer>
    </form>
</body>

</html>
