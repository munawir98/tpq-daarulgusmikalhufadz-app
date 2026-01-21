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
            class="flex items-center bg-gradient-to-r from-[#1A2980] to-[#26D0CE] h-14 px-6 sticky top-4 z-50 shadow-lg shadow-blue-900/20 mx-6 rounded-2xl overflow-hidden">
            <!-- Pattern Overlay -->
            <div class="absolute inset-0 opacity-10 pointer-events-none"
                style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
            </div>
            <div class="w-full flex items-center justify-center relative z-10">
                <h1 class="text-white text-md font-bold leading-tight tracking-tight text-center drop-shadow-sm">
                    Kirim Notifikasi</h1>
            </div>
        </header>

        <main class="flex-1 max-w-md mx-auto w-full pb-44 px-6 pt-4 space-y-4">
            {{-- Success/Error Messages (Preserved Functional Logic) --}}
            @if(session('success'))
            <div
                class="p-4 bg-green-50 border border-green-200 rounded-xl text-green-600 text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">check_circle</span>
                {{ session('success') }}
            </div>
            @endif
            @if($errors->any())
            <div class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">error</span>
                {{ $errors->first() }}
            </div>
            @endif

            <!-- Section: Target Penerima -->
            <section class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm">
                <div class="mb-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-blue-600">Target Penerima</h3>
                </div>
                <!-- Functional Target Selection -->
                <div class="relative group">
                    <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400 text-xl">group</span>
                    </div>
                    <select name="target" id="targetSelect" onchange="toggleTargetDetails()"
                        class="w-full h-12 pl-10 pr-4 bg-slate-50 border-0 text-slate-700 rounded-xl text-sm font-semibold focus:ring-2 focus:ring-primary/20 transition-all appearance-none cursor-pointer">
                        <option value="all_santri">Semua Santri</option>
                        <option value="all_ustadz">Semua Ustadz</option>
                        <option value="all_users">Semua Pengguna</option>
                        <option value="specific_santri">Pilih Santri (Manual)</option>
                    </select>
                    <input type="hidden" name="title" value="Pemberitahuan" id="titleInput">
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400">expand_more</span>
                    </div>
                </div>

                <!-- Specific Santri Selection Mockup (Hidden by Default unless Specific selected) -->
                <div id="specificSantriSection"
                    class="mt-3 bg-slate-50 border border-slate-100 rounded-xl p-3 flex items-center gap-3 relative hidden">
                    <input type="hidden" name="santri_id" id="selectedSantriId">
                    <div
                        class="shrink-0 w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-slate-400">
                        <span class="material-symbols-outlined text-lg">person</span>
                    </div>
                    <div class="flex-1 relative">
                        <input type="text" id="santriSearchInput" placeholder="Ketik nama santri..." autocomplete="off"
                            class="w-full bg-transparent border-0 border-b border-gray-300 focus:ring-0 p-0 text-sm font-bold placeholder:font-normal text-slate-700">
                        <p class="text-[10px] text-slate-500 font-medium">Cari spesifik</p>

                        <!-- Search Results Dropdown -->
                        <div id="searchResults"
                            class="absolute left-0 right-0 top-full mt-1 bg-white border border-slate-200 rounded-xl shadow-lg z-50 max-h-48 overflow-y-auto hidden">
                            <!-- Results will be populated here -->
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section: Pilih Alasan -->
            <section class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm">
                <div class="mb-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-blue-600">Pilih Alasan</h3>
                </div>
                <div class="flex gap-2 overflow-x-auto no-scrollbar mask-linear scroll-smooth pb-1"
                    id="templateContainer">
                    <button type="button" onclick="setTemplate('Absensi', this)"
                        class="template-btn flex items-center justify-center rounded-full bg-primary text-white px-4 py-2 text-xs font-semibold whitespace-nowrap shadow-sm shadow-primary/20 shrink-0 transition-all">
                        Absensi
                    </button>
                    <button type="button" onclick="setTemplate('Izin Sakit', this)"
                        class="template-btn flex items-center justify-center rounded-full bg-slate-50 border border-slate-200 text-slate-600 px-4 py-2 text-xs font-medium whitespace-nowrap hover:bg-slate-100 shrink-0 transition-all">
                        Izin Sakit
                    </button>
                    <button type="button" onclick="setTemplate('Pertemuan', this)"
                        class="template-btn flex items-center justify-center rounded-full bg-slate-50 border border-slate-200 text-slate-600 px-4 py-2 text-xs font-medium whitespace-nowrap hover:bg-slate-100 shrink-0 transition-all">
                        Pertemuan
                    </button>
                    <button type="button" onclick="setTemplate('Lainnya', this)"
                        class="template-btn flex items-center justify-center rounded-full bg-slate-50 border border-slate-200 text-slate-600 px-4 py-2 text-xs font-medium whitespace-nowrap hover:bg-slate-100 shrink-0 transition-all">
                        Lainnya
                    </button>
                </div>
            </section>

            <!-- Section: Isi Pesan -->
            <section class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm">
                <div class="mb-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-blue-600">Isi Pesan</h3>
                </div>
                <div
                    class="bg-slate-50 border border-slate-200 rounded-xl overflow-hidden focus-within:ring-2 focus-within:ring-primary/10 focus-within:border-primary transition-all">
                    <textarea name="content" id="messageContent"
                        class="w-full bg-transparent border-none focus:ring-0 text-slate-700 p-4 min-h-[150px] text-sm leading-relaxed resize-none"
                        placeholder="Tulis pesan Anda di sini...">Assalamu'alaikum Warahmatullahi Wabarakatuh,
Bpk. Ridwan, kami dari TPQ Daarul Gusmik menginfokan bahwa Ahmad Syarif sudah tidak hadir selama 3 hari berturut-turut tanpa keterangan.
Mohon konfirmasinya. Terima kasih.</textarea>
                </div>
            </section>
        </main>

        <footer class="fixed bottom-0 left-0 right-0 p-6 bg-white border-t border-slate-100 z-50">
            <div class="max-w-md mx-auto flex flex-col gap-3">
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" onclick="sendWhatsApp()"
                        class="flex-1 h-14 bg-whatsapp hover:brightness-105 active:scale-[0.96] transition-all rounded-xl flex flex-col items-center justify-center text-white shadow-sm px-2">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                <path
                                    d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.417-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.305 1.652zm6.599-3.835c1.404.831 2.923 1.272 4.475 1.274h.005c5.446 0 9.879-4.432 9.882-9.879.002-2.64-1.026-5.122-2.895-6.991-1.87-1.869-4.353-2.895-6.992-2.896-5.447 0-9.88 4.432-9.883 9.88-.001 1.742.454 3.441 1.319 4.938l-1.018 3.717 3.804-.997zm11.332-6.852c-.311-.156-1.843-.909-2.13-.997-.287-.11-.497-.156-.708.156-.21.312-.816 1.023-.997 1.23-.18.21-.363.235-.674.079-.311-.156-1.316-.485-2.503-1.543-.924-.825-1.548-1.844-1.73-2.155-.182-.312-.019-.481.137-.635.141-.14.312-.364.468-.546.155-.182.208-.312.312-.52.103-.208.052-.39-.026-.546-.078-.156-.708-1.705-.97-2.336-.254-.614-.515-.53-.708-.54l-.604-.012c-.21 0-.552.079-.841.391s-1.103 1.077-1.103 2.628c0 1.551 1.129 3.045 1.286 3.253.158.208 2.222 3.393 5.383 4.759.752.324 1.338.518 1.796.664.755.24 1.442.207 1.984.126.604-.091 1.843-.753 2.102-1.48s.258-1.35.182-1.48-.285-.208-.595-.364z" />
                            </svg>
                            <span class="text-xs font-bold leading-none">WhatsApp</span>
                        </div>
                    </button>
                    <button type="submit"
                        class="flex-1 h-14 bg-primary hover:brightness-105 active:scale-[0.96] transition-all rounded-xl flex flex-col items-center justify-center text-white shadow-sm px-2">
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-xl">notifications_active</span>
                            <span class="text-xs font-bold leading-none text-center">Notifikasi App</span>
                        </div>
                    </button>
                </div>
            </div>
            <p class="text-xs text-slate-400 text-center leading-tight">
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

        // Santri Search Logic
        const searchInput = document.getElementById('santriSearchInput');
        const searchResults = document.getElementById('searchResults');
        const selectedSantriId = document.getElementById('selectedSantriId');
        let debounceTimer;

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                const query = this.value;

                if (query.length < 2) {
                    searchResults.classList.add('hidden');
                    return;
                }

                debounceTimer = setTimeout(() => {
                    // Show loading
                    searchResults.innerHTML = '<div class="p-3 text-xs text-slate-400 text-center">Mencari...</div>';
                    searchResults.classList.remove('hidden');

                    fetch(`{{ route('ustadz.broadcast.search.santri') }}?q=${query}`)
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(data => {
                            searchResults.innerHTML = '';
                            if (data.length > 0) {
                                data.forEach(santri => {
                                    const div = document.createElement('div');
                                    div.className = 'p-3 hover:bg-slate-50 cursor-pointer border-b border-slate-100 last:border-0';
                                    div.innerHTML = `
                                        <p class="text-sm font-bold text-slate-800">${santri.nama_lengkap}</p>
                                        <p class="text-xs text-slate-500">${santri.nis}</p>
                                    `;
                                    div.onclick = () => {
                                        searchInput.value = santri.nama_lengkap;
                                        selectedSantriId.value = santri.id;
                                        searchResults.classList.add('hidden');
                                    };
                                    searchResults.appendChild(div);
                                });
                            } else {
                                searchResults.innerHTML = '<div class="p-3 text-xs text-slate-400 text-center">Tidak ditemukan</div>';
                            }
                            searchResults.classList.remove('hidden');
                        })
                        .catch(error => {
                            console.error('Error fetching santri:', error);
                            searchResults.innerHTML = '<div class="p-3 text-xs text-red-400 text-center">Gagal memuat data</div>';
                            searchResults.classList.remove('hidden');
                        });
                }, 300);
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function (e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.classList.add('hidden');
                }
            });
        }
    </script>
</body>

</html>
