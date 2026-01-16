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
    <form action="{{ route('ustadz.broadcast.store') }}" method="POST" class="flex flex-col flex-1">
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
            {{-- Success/Error Messages (Inserted) --}}
            @if(session('success'))
            <div
                class="p-4 mx-4 mt-4 bg-green-50 border border-green-200 rounded-xl text-green-600 text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">check_circle</span>
                {{ session('success') }}
            </div>
            @endif
            @if($errors->any())
            <div
                class="p-4 mx-4 mt-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">error</span>
                {{ $errors->first() }}
            </div>
            @endif

            <section class="p-4">
                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div class="w-16 h-16 rounded-full bg-cover bg-center border-2 border-primary/20 flex items-center justify-center bg-white"
                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBsPh3V9snwxqJ69AnhvGeQwvOVnZ6L0e0vMJ9Q9WkfxLRrTPkV7pirsmN3bp5RT7LdXnOkk4dEuRBqYQ4Jl8uWSIv22i9KZghv0YJzYufRtuBxztQNVEH_B4aGqYUr148_C03mpqH88WGbaX6NBXax5nDi32S4zcbGkUjDYl2j5zOkQkcCjlDd-bvBT3kcuuhaUEL0T_JS88T7V3pCoGHtwpGtNNAKOaek38IcIm75A_LZcxzhimSyVNtDEwuHRQhPolYF32GkIhx9')">
                                {{-- Placeholder hidden if image loads, or use dynamic --}}
                            </div>
                            <div
                                class="absolute -bottom-1 -right-1 bg-primary text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full border-2 border-white">
                                TARGET</div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <span
                                    class="text-[10px] font-bold uppercase tracking-wider text-amber-600 bg-amber-50 px-2 py-0.5 rounded border border-amber-100">Broadcast</span>
                            </div>
                            <!-- Replaced Static Name with Select -->
                            <div class="relative">
                                <select name="target"
                                    class="w-full bg-transparent border-0 border-b border-gray-300 focus:border-primary focus:ring-0 text-lg font-bold p-0 pr-8 leading-none text-slate-900 cursor-pointer">
                                    <option value="all_santri">Semua Santri</option>
                                    <option value="all_ustadz">Semua Ustadz</option>
                                    <option value="all_users">Semua Pengguna</option>
                                </select>
                                <span
                                    class="material-symbols-outlined absolute right-0 top-0 text-gray-400 pointer-events-none">expand_more</span>
                            </div>
                            <p class="text-sm text-slate-500 mt-1.5 flex items-center gap-1">
                                <span class="material-symbols-outlined text-base">groups</span>
                                Pilih Penerima
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Title Input (Added functionally) -->
            <section class="px-4 mt-2">
                <input type="text" name="title"
                    class="w-full rounded-xl border-gray-200 focus:border-primary focus:ring-primary text-sm p-3 font-bold placeholder:font-normal"
                    placeholder="Judul Pengumuman" required>
            </section>

            <section class="mt-2">
                <div class="px-4 mb-3 flex items-center justify-between">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Pilih Template Pesan</h3>
                    <span class="text-xs font-medium text-primary bg-primary/5 px-2 py-0.5 rounded-full">3
                        Tersedia</span>
                </div>
                <div class="flex gap-3 px-4 overflow-x-auto no-scrollbar pb-2">
                    <button type="button"
                        class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-full bg-primary text-white px-5 text-sm font-semibold shadow-md shadow-primary/20 whitespace-nowrap"
                        onclick="setTemplate('Absensi')">
                        <span class="material-symbols-outlined text-lg">event_busy</span>
                        Absensi
                    </button>
                    <button type="button"
                        class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-full bg-white border border-slate-200 text-slate-600 px-5 text-sm font-medium whitespace-nowrap"
                        onclick="setTemplate('Izin Sakit')">
                        <span class="material-symbols-outlined text-lg text-slate-400">medical_services</span>
                        Izin Sakit
                    </button>
                    <button type="button"
                        class="flex h-10 shrink-0 items-center justify-center gap-x-2 rounded-full bg-white border border-slate-200 text-slate-600 px-5 text-sm font-medium whitespace-nowrap"
                        onclick="setTemplate('Pertemuan')">
                        <span class="material-symbols-outlined text-lg text-slate-400">groups</span>
                        Pertemuan
                    </button>
                </div>
            </section>

            <section class="p-4 mt-2">
                <div class="mb-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Isi Pesan</h3>
                </div>
                <div
                    class="relative bg-white border border-slate-200 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-primary/20 focus-within:border-primary transition-all">
                    <textarea name="content" id="messageContent"
                        class="w-full bg-transparent border-none focus:ring-0 text-slate-700 p-4 min-h-[200px] text-base leading-relaxed"
                        placeholder="Tulis pesan Anda di sini...">Assalamu'alaikum Warahmatullahi Wabarakatuh,
Kami dari TPQ Daarul Gusmik menginfokan pengumuman penting bagi seluruh santri.
Mohon perhatiannya. Terima kasih.</textarea>
                    <div class="bg-slate-50 px-4 py-3 border-t border-slate-100 flex justify-between items-center">
                        <span class="text-[10px] text-slate-400 uppercase font-medium tracking-wide">Karakter: <span
                                id="charCount">0</span></span>
                        <button type="button" onclick="document.getElementById('messageContent').value=''"
                            class="text-primary text-xs font-bold flex items-center gap-1 px-2 py-1 hover:bg-primary/5 rounded">
                            <span class="material-symbols-outlined text-base">restart_alt</span>
                            Reset
                        </button>
                    </div>
                </div>
            </section>

            <section class="px-4 py-2">
                <div class="flex gap-3 bg-blue-50 border border-blue-100 p-4 rounded-xl">
                    <span class="material-symbols-outlined text-blue-500 text-xl shrink-0">info</span>
                    <p class="text-xs text-blue-700 leading-relaxed font-medium">
                        Pesan melalui WhatsApp akan membuka aplikasi secara otomatis dengan teks yang sudah terisi di
                        jendela
                        percakapan.
                    </p>
                </div>
            </section>
        </main>

        <footer class="fixed bottom-0 left-0 right-0 p-4 bg-white/90 ios-blur border-t border-slate-100 z-50">
            <div class="max-w-md mx-auto flex flex-col gap-3">
                <button type="button" onclick="sendWhatsApp()"
                    class="w-full h-14 bg-whatsapp hover:brightness-105 active:scale-[0.98] transition-all rounded-xl flex items-center justify-center gap-3 text-white font-bold text-lg shadow-lg shadow-whatsapp/20">
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                        <path
                            d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.417-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.305 1.652zm6.599-3.835c1.404.831 2.923 1.272 4.475 1.274h.005c5.446 0 9.879-4.432 9.882-9.879.002-2.64-1.026-5.122-2.895-6.991-1.87-1.869-4.353-2.895-6.992-2.896-5.447 0-9.88 4.432-9.883 9.88-.001 1.742.454 3.441 1.319 4.938l-1.018 3.717 3.804-.997zm11.332-6.852c-.311-.156-1.843-.909-2.13-.997-.287-.11-.497-.156-.708.156-.21.312-.816 1.023-.997 1.23-.18.21-.363.235-.674.079-.311-.156-1.316-.485-2.503-1.543-.924-.825-1.548-1.844-1.73-2.155-.182-.312-.019-.481.137-.635.141-.14.312-.364.468-.546.155-.182.208-.312.312-.52.103-.208.052-.39-.026-.546-.078-.156-.708-1.705-.97-2.336-.254-.614-.515-.53-.708-.54l-.604-.012c-.21 0-.552.079-.841.391s-1.103 1.077-1.103 2.628c0 1.551 1.129 3.045 1.286 3.253.158.208 2.222 3.393 5.383 4.759.752.324 1.338.518 1.796.664.755.24 1.442.207 1.984.126.604-.091 1.843-.753 2.102-1.48s.258-1.35.182-1.48-.285-.208-.595-.364z" />
                    </svg>
                    Kirim via WhatsApp
                </button>
                <button type="submit"
                    class="w-full h-14 bg-primary hover:brightness-105 active:scale-[0.98] transition-all rounded-xl flex items-center justify-center gap-2 text-white font-bold text-lg shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined">notifications_active</span>
                    Notifikasi App
                </button>
            </div>
        </footer>
    </form>

    <script>
        // Character counter
        const textarea = document.getElementById('messageContent');
        const countSpan = document.getElementById('charCount');

        function updateCount() {
            countSpan.innerText = textarea.value.length;
        }

        textarea.addEventListener('input', updateCount);
        updateCount(); // Init

        // Template Setter
        function setTemplate(type) {
            let text = "";
            if (type === 'Absensi') {
                text = "Assalamu'alaikum Warahmatullahi Wabarakatuh,\nKami menginfokan bahwa ... tidak hadir hari ini tanpa keterangan.\nMohon konfirmasinya. Terima kasih.";
            } else if (type === 'Izin Sakit') {
                text = "Assalamu'alaikum Warahmatullahi Wabarakatuh,\nKami menerima info bahwa ... sakit hari ini.\nSemoga lekas sembuh. Terima kasih.";
            } else if (type === 'Pertemuan') {
                text = "Assalamu'alaikum Warahmatullahi Wabarakatuh,\nUndangan pertemuan wali santri pada tanggal ... di TPQ.\nDiharapkan kehadirannya. Terima kasih.";
            }
            textarea.value = text;
            updateCount();
        }

        // Dummy sendWhatsApp function
        function sendWhatsApp() {
            const msg = encodeURIComponent(textarea.value);
            window.open(`https://wa.me/?text=${msg}`, '_blank');
        }
    </script>
</body>

</html>
