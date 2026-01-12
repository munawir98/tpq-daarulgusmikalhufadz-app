<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Pratinjau Cetak PDF Kehadiran Santri</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#0d9488",
                        "ocean-dark": "#0f766e",
                        "ocean-light": "#2dd4bf",
                        "background-light": "#f1f5f9",
                        "background-dark": "#0f172a",
                        "card-light": "#ffffff",
                        "card-dark": "#1e293b",
                    },
                    fontFamily: {
                        display: ["Poppins", "sans-serif"],
                        serif: ["Times New Roman", "Times", "serif"],
                    },
                    backgroundImage: {
                        'header-pattern': "repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255,255,255,0.05) 10px, rgba(255,255,255,0.05) 20px)",
                    }
                },
            },
        };
    </script>
    <style type="text/tailwindcss">
        :root {
            --primary-color: #0d9488;
        }

        body {
            font-family: 'Poppins', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        .paper-shadow {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /* A4 Paper Simulation (Landscape) */
        @media screen {
            .a4-paper {
                width: 297mm;
                min-height: 210mm;
                padding: 20mm;
                margin: 0 auto;
            }
        }

        /* Mobile adjustment */
        @media screen and (max-width: 640px) {
            .a4-paper {
                width: 297mm; /* Force landscape width even on mobile to allow scroll */
                min-width: 100%;
                padding: 15px;
            }
        }

        @media print {
            @page {
                size: A4 landscape;
                margin: 0;
            }
            body * {
                visibility: hidden;
            }
            .a4-paper, .a4-paper * {
                visibility: visible;
            }
            .a4-paper {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
                box-shadow: none;
            }
        }
    </style>
</head>

<body
    class="bg-slate-100 dark:bg-background-dark h-screen w-full overflow-hidden flex flex-col font-display text-slate-800 dark:text-slate-100">
    <!-- Header -->
    <header class="bg-primary dark:bg-teal-950 relative shrink-0 z-50 shadow-md">
        <div class="absolute inset-0 bg-header-pattern pointer-events-none"></div>
        <div class="relative z-10 pt-6 pb-4 px-6 flex items-center gap-4">
            <button class="bg-white/20 hover:bg-white/30 p-2 rounded-full backdrop-blur-sm text-white transition-colors"
                onclick="window.print()">
                <span class="material-icons-round">print</span>
            </button>
            <div class="text-white">
                <h1 class="text-lg font-bold leading-tight">Pratinjau</h1>
                <p class="text-[10px] opacity-80 uppercase tracking-widest mt-0.5">Laporan Kehadiran</p>
            </div>
        </div>
    </header>

    <!-- Content Preview -->
    <main class="flex-1 overflow-auto p-4 md:p-8 pb-40 bg-slate-200 dark:bg-slate-900 scrollbar-hide">
        <!-- A4 Paper Container -->
        <div class="a4-paper bg-white text-slate-900 paper-shadow flex flex-col mb-10 relative rounded-sm">

            <!-- Kop Surat -->
            <div class="flex items-center gap-6 border-b-4 border-double border-slate-800 pb-6 mb-8">
                <div class="w-24 h-24 bg-teal-600 rounded-xl flex items-center justify-center text-white shrink-0">
                    <span class="material-icons-round text-5xl">mosque</span>
                </div>
                <div class="text-center flex-1">
                    <h2 class="text-2xl font-bold uppercase tracking-wider font-serif">TPQ AL-ISTIQOMAH</h2>
                    <p class="text-sm font-semibold tracking-widest text-slate-600 uppercase mt-1">Lembaga Pendidikan
                        Al-Qur'an</p>
                    <p class="text-xs text-slate-600 mt-2">Jl. Pendidikan No. 123, Kota Madani, Indonesia 40123</p>
                    <p class="text-xs text-slate-600">Telp: (021) 555-0123 | Email: info@tpq-istiqomah.sch.id</p>
                </div>
            </div>

            <!-- Title -->
            <div class="text-center mb-8">
                <h3 class="text-lg font-bold uppercase underline underline-offset-4 decoration-2">Laporan Kehadiran
                    Santri</h3>
                <p class="text-sm font-medium text-slate-600 mt-2">Periode: <span class="font-bold text-slate-800">{{
                        now()->locale('id')->isoFormat('MMMM Y') }}</span></p>
            </div>

            <!-- Metadata Info -->
            <div class="flex justify-between mb-6 text-xs text-slate-700 font-medium">
                <div>
                    <p>Kelas: <span class="font-bold">Semua Kelas</span></p>
                </div>
                <div>
                    <p>Total Santri: <span class="font-bold">5</span></p>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-hidden border border-slate-300 rounded-lg mb-8">
                <table class="w-full text-xs border-collapse">
                    <thead>
                        <tr class="bg-slate-100 text-slate-700 uppercase tracking-wider font-bold">
                            <th class="py-3 px-3 text-center border-b border-r border-slate-300 w-10">No</th>
                            <th class="py-3 px-4 text-left border-b border-r border-slate-300">Nama Santri</th>
                            <th class="py-3 px-2 text-center border-b border-r border-slate-300 w-16 bg-green-50">Hadir
                            </th>
                            <th class="py-3 px-2 text-center border-b border-r border-slate-300 w-16 bg-amber-50">Izin
                            </th>
                            <th class="py-3 px-2 text-center border-b border-r border-slate-300 w-16 bg-red-50">Alfa
                            </th>
                            <th class="py-3 px-3 text-center border-b border-slate-300 w-24">Persentase</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-2.5 px-3 text-center border-r border-slate-200">1</td>
                            <td class="py-2.5 px-4 text-left border-r border-slate-200 font-medium">Ahmad Syafi'i</td>
                            <td class="py-2.5 px-2 text-center border-r border-slate-200 bg-green-50/30">20</td>
                            <td class="py-2.5 px-2 text-center border-r border-slate-200 bg-amber-50/30">2</td>
                            <td class="py-2.5 px-2 text-center border-r border-slate-200 bg-red-50/30">0</td>
                            <td class="py-2.5 px-3 text-center font-bold text-teal-700">90%</td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors bg-slate-50/50">
                            <td class="py-2.5 px-3 text-center border-r border-slate-200">2</td>
                            <td class="py-2.5 px-4 text-left border-r border-slate-200 font-medium">Fatimah Az-Zahra
                            </td>
                            <td class="py-2.5 px-2 text-center border-r border-slate-200 bg-green-50/30">22</td>
                            <td class="py-2.5 px-2 text-center border-r border-slate-200 bg-amber-50/30">0</td>
                            <td class="py-2.5 px-2 text-center border-r border-slate-200 bg-red-50/30">0</td>
                            <td class="py-2.5 px-3 text-center font-bold text-teal-700">100%</td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-2.5 px-3 text-center border-r border-slate-200">3</td>
                            <td class="py-2.5 px-4 text-left border-r border-slate-200 font-medium">Zaid Al-Khoir</td>
                            <td class="py-2.5 px-2 text-center border-r border-slate-200 bg-green-50/30">16</td>
                            <td class="py-2.5 px-2 text-center border-r border-slate-200 bg-amber-50/30">4</td>
                            <td class="py-2.5 px-2 text-center border-r border-slate-200 bg-red-50/30">2</td>
                            <td class="py-2.5 px-3 text-center font-bold text-amber-600">72%</td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors bg-slate-50/50">
                            <td class="py-2.5 px-3 text-center border-r border-slate-200">4</td>
                            <td class="py-2.5 px-4 text-left border-r border-slate-200 font-medium">Maryam Nurul Huda
                            </td>
                            <td class="py-2.5 px-2 text-center border-r border-slate-200 bg-green-50/30">19</td>
                            <td class="py-2.5 px-2 text-center border-r border-slate-200 bg-amber-50/30">2</td>
                            <td class="py-2.5 px-2 text-center border-r border-slate-200 bg-red-50/30">1</td>
                            <td class="py-2.5 px-3 text-center font-bold text-teal-700">86%</td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-2.5 px-3 text-center border-r border-slate-200">5</td>
                            <td class="py-2.5 px-4 text-left border-r border-slate-200 font-medium">Umar Bin Khattab
                            </td>
                            <td class="py-2.5 px-2 text-center border-r border-slate-200 bg-green-50/30">21</td>
                            <td class="py-2.5 px-2 text-center border-r border-slate-200 bg-amber-50/30">1</td>
                            <td class="py-2.5 px-2 text-center border-r border-slate-200 bg-red-50/30">0</td>
                            <td class="py-2.5 px-3 text-center font-bold text-teal-700">95%</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Signature Section -->
            <div class="mt-auto pt-10 flex justify-end">
                <div class="text-center w-64 relative">
                    <p class="text-xs text-slate-600 mb-1">Kota Madani, {{ now()->locale('id')->isoFormat('D MMMM Y') }}
                    </p>
                    <p class="text-xs font-bold relative z-10">Kepala TPQ Al-Istiqomah</p>
                    <div class="h-28 flex items-center justify-center relative">
                        <!-- Tanda Tangan -->
                        <img src="{{ asset('ttd-kepala.png') }}"
                            class="h-full w-auto object-contain relative z-10 scale-125" alt="Tanda Tangan">

                        <!-- Stempel (Overlapping) -->
                        <img src="{{ asset('stempel.png') }}"
                            class="absolute -left-4 top-1/2 -translate-y-1/2 h-24 w-auto object-contain opacity-80 -rotate-12 mix-blend-multiply"
                            alt="Stempel">
                    </div>
                    <p class="text-xs font-bold border-b border-slate-800 inline-block px-1 mb-1 relative z-10">Ust. H.
                        Abdul Malik,
                        Lc</p>
                    <p class="text-[10px] text-slate-500">NIP. 19820512 201001 1 002</p>
                </div>
            </div>

            <!-- Footer (Print Only) -->
            <div class="absolute bottom-4 left-0 w-full text-center print:block hidden">
                <p class="text-[9px] text-slate-400 italic">Dicetak secara otomatis melalui Sistem Informasi TPQ pada {{
                    now()->format('d/m/Y H:i') }}</p>
            </div>

        </div>
    </main>

    <!-- Bottom Actions -->
    <div
        class="fixed bottom-0 left-0 w-full bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 px-6 pt-3 pb-3 z-50 shadow-[0_-10px_40px_rgba(0,0,0,0.1)]">
        <div class="flex gap-3 max-w-sm mx-auto">
            <button onclick="window.print()"
                class="flex-1 flex items-center justify-center gap-2 bg-teal-600 hover:bg-teal-700 text-white p-3.5 rounded-xl font-semibold shadow-lg shadow-teal-500/20 transition-all active:scale-[0.98]">
                <span class="material-icons-round text-xl leading-none">print</span>
                <span class="text-sm whitespace-nowrap">Cetak</span>
            </button>
            <button id="btnShare"
                class="flex-1 flex items-center justify-center gap-2 bg-white dark:bg-slate-800 border-2 border-teal-600 text-teal-600 dark:text-teal-400 p-3.5 rounded-xl font-semibold transition-all active:scale-[0.98]">
                <span class="material-icons-round text-xl leading-none">share</span>
                <span class="text-sm whitespace-nowrap">Bagikan</span>
            </button>
        </div>
    </div>

    <!-- Script Share -->
    <script>
        document.getElementById('btnShare').addEventListener('click', async () => {
            if (navigator.share) {
                try {
                    await navigator.share({
                        title: 'Laporan Kehadiran Santri',
                        text: 'Laporan kehadiran santri periode Oktober 2023',
                        url: window.location.href,
                    });
                } catch (err) {
                    console.error('Share failed:', err);
                }
            } else {
                alert('Fitur share tidak didukung di browser ini.');
            }
        });
    </script>
</body>

</html>
