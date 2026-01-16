<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Kirim Notifikasi Pilih Santri</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&amp;display=swap"
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
                        "display": ["Poppins", "sans-serif"]
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
            font-family: 'Poppins', sans-serif;
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
    <style>
        body {
            min-height: max(884px, 100dvh);
        }
    </style>
</head>

<body class="bg-white text-slate-900 min-h-screen flex flex-col">
    <form action="{{ route('ustadz.broadcast.store') }}" method="POST" class="flex flex-col flex-1 h-full">
        @csrf
        <header
            class="flex items-center bg-primary dark:bg-slate-900 h-14 px-4 sticky top-0 z-50 border-b border-primary dark:border-slate-800 shadow-sm">
            <div class="w-full flex items-center justify-center relative">
                <h1 class="text-white dark:text-white text-base font-bold leading-tight tracking-tight text-center">
                    Kirim Notifikasi</h1>
            </div>
        </header>

        <main class="flex-1 max-w-md mx-auto w-full pb-44">
            {{-- Success/Error Messages (Preserved Functional Logic) --}}
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
                <div class="mb-2">
                    <h3 class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Target Penerima</h3>
                </div>
                <!-- Functional Target Selection -->
                <div class="relative group">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400 text-xl">group</span>
                    </div>
                    <select name="target" id="targetSelect" onchange="toggleTargetDetails()"
                        class="w-full h-12 pl-10 pr-10 bg-white border border-slate-200 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-primary/10 focus:border-primary transition-all appearance-none cursor-pointer">
                        <option value="all_santri">Semua Santri</option>
                        <option value="all_ustadz">Semua Ustadz</option>
                        <option value="all_users">Semua Pengguna</option>
                        <option value="specific_santri">Pilih Santri (Manual)</option>
                    </select>
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400 text-xl">expand_more</span>
                    </div>
                    <input type="hidden" name="title" value="Pemberitahuan" id="titleInput">
                </div>
            </section>

            <!-- Specific Santri Selection Mockup (Hidden by Default unless Specific selected) -->
            <section class="px-4 hidden" id="specificSantriSection">
                <div class="bg-slate-50 border border-slate-100 rounded-xl p-3 flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-cover bg-center border border-slate-200"
                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBsPh3V9snwxqJ69AnhvGeQwvOVnZ6L0e0vMJ9Q9WkfxLRrTPkV7pirsmN3bp5RT7LdXnOkk4dEuRBqYQ4Jl8uWSIv22i9KZghv0YJzYufRtuBxztQNVEH_B4aGqYUr148_C03mpqH88WGbaX6NBXax5nDi32S4zcbGkUjDYl2j5zOkQkcCjlDd-bvBT3kcuuhaUEL0T_JS88T7V3pCoGHtwpGtNNAKOaek38IcIm75A_LZcxzhimSyVNtDEwuHRQhPolYF32GkIhx9')">
                    </div>
                    <div class="flex-1">
                        <input type="text" placeholder="Ketik nama santri..."
                            class="w-full bg-transparent border-0 border-b border-gray-300 focus:ring-0 p-0 text-sm font-bold placeholder:font-normal">
                        <p class="text-[10px] text-slate-500 font-medium">Cari spesifik</p>
                    </div>
                </div>
            </section>

            <section class="mt-4">
                <div class="px-4 mb-2">
                    <h3 class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Pilih Alasan</h3>
                </div>
                <div class="flex gap-2 px-4 overflow-x-auto no-scrollbar pb-3 mask-linear scroll-smooth"
                    id="templateContainer">
                    <button type="button" onclick="setTemplate('Absensi', this)"
                        class="template-btn flex items-center justify-center rounded-full bg-primary text-white px-4 py-2 text-xs font-semibold whitespace-nowrap shadow-sm shadow-primary/20 shrink-0 transition-all">
                        Absensi
                    </button>
                    <button type="button" onclick="setTemplate('Izin Sakit', this)"
                        class="template-btn flex items-center justify-center rounded-full bg-white border border-slate-200 text-slate-600 px-4 py-2 text-xs font-medium whitespace-nowrap hover:bg-slate-50 shrink-0 transition-all">
                        Izin Sakit
                    </button>
                    <button type="button" onclick="setTemplate('Pertemuan', this)"
                        class="template-btn flex items-center justify-center rounded-full bg-white border border-slate-200 text-slate-600 px-4 py-2 text-xs font-medium whitespace-nowrap hover:bg-slate-50 shrink-0 transition-all">
                        Pertemuan
                    </button>
                    <button type="button" onclick="setTemplate('Lainnya', this)"
                        class="template-btn flex items-center justify-center rounded-full bg-white border border-slate-200 text-slate-600 px-4 py-2 text-xs font-medium whitespace-nowrap hover:bg-slate-50 shrink-0 transition-all">
                        Lainnya
                    </button>
                    <div class="w-2 shrink-0"></div>
                </div>
            </section>

            <section class="p-4 mt-2">
                <div class="mb-2">
                    <h3 class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Isi Pesan</h3>
                </div>
                <div
                    class="bg-white border border-slate-200 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-primary/10 focus-within:border-primary transition-all">
                    <textarea name="content" id="messageContent"
                        class="w-full bg-transparent border-none focus:ring-0 text-slate-700 p-4 min-h-[180px] text-xs leading-relaxed resize-none"
                        placeholder="Tulis pesan Anda di sini...">Assalamu'alaikum Warahmatullahi Wabarakatuh,
Bpk. Ridwan, kami dari TPQ Daarul Gusmik menginfokan bahwa Ahmad Syarif sudah tidak hadir selama 3 hari berturut-turut tanpa keterangan.
Mohon konfirmasinya. Terima kasih.</textarea>
                </div>
            </section>
        </main>

        <footer class="fixed bottom-0 left-0 right-0 p-4 bg-white border-t border-slate-100 z-50">
            <div class="max-w-md mx-auto flex flex-col gap-3">
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" onclick="sendWhatsApp()"
                        class="flex-1 h-14 bg-whatsapp hover:brightness-105 active:scale-[0.96] transition-all rounded-xl flex flex-col items-center justify-center text-white shadow-sm px-2">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.417-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.305 1.652zm6.599-3.835c1.404.831 2.923 1.272 4.475 1.274h.005c5.446 0 9.879-4.432 9.882-9.879.002-2.64-1.026-5.122-2.895-6.991-1.87-1.869-4.353-2.895-6.992-2.896-5.447 0-9.88 4.432-9.883 9.88-.001 1.742.454 3.441 1.319 4.938l-1.018 3.717 3.804-.997zm11.332-6.852c-.311-.156-1.843-.909-2.13-.997-.287-.11-.497-.156-.708.156-.21.312-.816 1.023-.997 1.23-.18.21-.363.235-.674.079-.311-.156-1.316-.485-2.503-1.543-.924-.825-1.548-1.844-1.73-2.155-.182-.312-.019-.481.137-.635.141-.14.312-.364.468-.546.155-.182.208-.312.312-.52.103-.208.052-.39-.026-.546-.078-.156-.708-1.705-.97-2.336-.254-.614-.515-.53-.708-.54l-.604-.012c-.21 0-.552.079-.841.391s-1.103 1.077-1.103 2.628c0 1.551 1.129 3.045 1.286 3.253.158.208 2.222 3.393 5.383 4.759.752.324 1.338.518 1.796.664.755.24 1.442.207 1.984.126.604-.091 1.843-.753 2.102-1.48s.258-1.35.182-1.48-.285-.208-.595-.364z" />
                            </svg>
                            <span class="text-[11px] font-bold leading-none">WhatsApp</span>
                        </div>
                    </button>
                    <button type="submit"
                        class="flex-1 h-14 bg-primary hover:brightness-105 active:scale-[0.96] transition-all rounded-xl flex flex-col items-center justify-center text-white shadow-sm px-2">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-xl">notifications_active</span>
                            <span class="text-[11px] font-bold leading-none text-center">Notifikasi App</span>
                        </div>
                    </button>
                </div>
            </div>
            <p class="text-[10px] text-slate-400 text-center leading-tight">
                Pesan dikirim ke aplikasi orang tua atau via WhatsApp.
            </p>
            </div>
        </footer>
    </form>

    <script>
        const textarea = document.getElementById('messageContent');
        const titleInput = document.getElementById('titleInput');

        function setTemplate(type, btnElement) {
            // Update UI State
            document.querySelectorAll('.template-btn').forEach(btn => {
                // Reset to inactive state
                btn.className = "template-btn flex items-center justify-center rounded-full bg-white border border-slate-200 text-slate-600 px-4 py-2 text-xs font-medium whitespace-nowrap hover:bg-slate-50 shrink-0 transition-all";
            });

            // Set active state
            if (btnElement) {
                btnElement.className = "template-btn flex items-center justify-center rounded-full bg-primary text-white px-4 py-2 text-xs font-semibold whitespace-nowrap shadow-sm shadow-primary/20 shrink-0 transition-all";
                // Scroll into view
                btnElement.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }

            // Set Content
            let text = "";
            let title = "";
            if (type === 'Absensi') {
                title = "Pemberitahuan Absensi";
                text = "Assalamu'alaikum Warahmatullahi Wabarakatuh,\nKami menginfokan bahwa ... tidak hadir hari ini tanpa keterangan.\nMohon konfirmasinya. Terima kasih.";
            } else if (type === 'Izin Sakit') {
                title = "Konfirmasi Izin Sakit";
                text = "Assalamu'alaikum Warahmatullahi Wabarakatuh,\nKami menerima info bahwa ... sakit hari ini.\nSemoga lekas sembuh. Terima kasih.";
            } else if (type === 'Pertemuan') {
                title = "Undangan Pertemuan";
                text = "Assalamu'alaikum Warahmatullahi Wabarakatuh,\nUndangan pertemuan wali santri pada tanggal ... di TPQ.\nDiharapkan kehadirannya. Terima kasih.";
            } else {
                title = "Informasi Umum";
                text = "Assalamu'alaikum Warahmatullahi Wabarakatuh,\n";
            }
            if (textarea) textarea.value = text;
            if (titleInput) titleInput.value = title;
        }

        function toggleTargetDetails() {
            const select = document.getElementById('targetSelect');
            const section = document.getElementById('specificSantriSection');
            if (select.value === 'specific_santri') {
                section.classList.remove('hidden');
            } else {
                section.classList.add('hidden');
            }
        }

        function sendWhatsApp() {
            if (textarea) {
                const msg = encodeURIComponent(textarea.value);
                window.open(`https://wa.me/?text=${msg}`, '_blank');
            }
        }
    </script>
</body>

</html>
