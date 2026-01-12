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
        @keyframes appear {
            0% {
                opacity: 0;
                transform: scale(0.9) translateY(20px);
                filter: brightness(0.5) blur(4px);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
                filter: brightness(1) blur(0);
            }
        }
        .animate-appear {
            animation: appear 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
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

    <!-- Loading Overlay -->
    <div id="pageLoader"
        class="fixed inset-0 z-[100] bg-slate-100 dark:bg-background-dark flex flex-col items-center justify-center transition-opacity duration-500">
        <div class="relative flex items-center justify-center">
            <div class="absolute animate-ping inline-flex h-12 w-12 rounded-full bg-teal-400 opacity-75"></div>
            <div class="relative inline-flex rounded-full h-8 w-8 bg-teal-500"></div>
        </div>
        <p class="mt-4 text-sm font-semibold text-slate-600 dark:text-slate-400 tracking-widest animate-pulse">MEMUAT...
        </p>
    </div>

    <!-- Content Preview -->
    <main class="flex-1 overflow-auto p-4 md:p-8 pb-40 bg-slate-200 dark:bg-slate-900 scrollbar-hide">
        <!-- A4 Paper Container -->
        <div id="paperContainer"
            class="a4-paper bg-white text-slate-900 paper-shadow flex flex-col mb-10 relative rounded-sm opacity-0 transform scale-95">

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

    <!-- Floating Hint -->
    <div id="zoomHint"
        class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-40 pointer-events-none transition-opacity duration-300">
        <div
            class="bg-slate-900/60 text-white px-3 py-1.5 rounded-full text-[10px] font-medium backdrop-blur-md shadow-md flex items-center gap-1 animate-pulse border border-white/10">
            <span class="material-icons-round text-xs">zoom_in</span> Lihat Tampilan Penuh
        </div>
    </div>

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

    <!-- Zoom Modal -->
    <div id="zoomModal"
        class="fixed inset-0 z-[60] bg-black/95 backdrop-blur-sm hidden overflow-hidden touch-none opacity-0 transition-opacity duration-500 ease-in-out">

        <!-- Floating Header Controls -->
        <div class="fixed top-0 left-0 w-full p-4 flex justify-end items-center z-[70] pointer-events-none">
            <button id="closeZoomBtn"
                class="text-white/70 hover:text-white bg-white/10 hover:bg-white/20 p-2 rounded-full transition-all backdrop-blur-md pointer-events-auto border border-white/5">
                <span class="material-icons-round text-2xl">close</span>
            </button>
        </div>

        <!-- Transient Zoom Level Indicator (Center Screen) -->
        <div id="zoomIndicator"
            class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[80] pointer-events-none opacity-0 transition-opacity duration-300">
            <div
                class="bg-black/60 backdrop-blur-md text-white px-4 py-2 rounded-full text-sm font-bold border border-white/10 shadow-xl">
                <span id="zoomLevel">50%</span>
            </div>
        </div>

        <!-- Floating Zoom Controls (Bottom Center) -->
        <div class="fixed bottom-8 left-1/2 -translate-x-1/2 z-[70] flex gap-6 pointer-events-auto">
            <button id="zoomOutBtn"
                class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white w-10 h-10 flex items-center justify-center rounded-full transition-all active:scale-95 border border-white/10">
                <span class="material-icons-round text-lg">remove</span>
            </button>
            <button id="resetZoomBtn"
                class="bg-teal-600 hover:bg-teal-500 text-white w-10 h-10 flex items-center justify-center rounded-full text-[10px] font-bold transition-all active:scale-95 shadow-lg shadow-teal-500/20 border border-teal-500/50 uppercase tracking-wider">
                Fit
            </button>
            <button id="zoomInBtn"
                class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white w-10 h-10 flex items-center justify-center rounded-full transition-all active:scale-95 border border-white/10">
                <span class="material-icons-round text-lg">add</span>
            </button>
        </div>

        <!-- content container for centering -->
        <div class="w-full h-full flex items-center justify-center overflow-hidden">
            <!-- Zoomed Content -->
            <div id="zoomContent"
                class="origin-center transition-transform duration-200 ease-out select-none will-change-transform">
                <!-- Content injected via JS -->
            </div>
        </div>
    </div>

    <!-- Script Share & Zoom -->
    <script>
        // --- Core Elements ---
        const paper = document.querySelector('.a4-paper');
        const modal = document.getElementById('zoomModal');
        const zoomContent = document.getElementById('zoomContent');
        const closeBtn = document.getElementById('closeZoomBtn');
        const zoomLevelDisplay = document.getElementById('zoomLevel');
        const zoomIndicator = document.getElementById('zoomIndicator');

        let currentScale = 1;
        let pannedX = 0;
        let pannedY = 0;
        let isDragging = false;
        let startX = 0, startY = 0;
        let lastTouchDistance = 0;
        let zoomTimeout;
        let hasMoved = false;

        // --- Page Load Animation ---
        window.addEventListener('load', () => {
            setTimeout(() => {
                const loader = document.getElementById('pageLoader');
                const paperContainer = document.getElementById('paperContainer');

                // Hide loader
                loader.classList.add('opacity-0');

                // Show paper with animation
                setTimeout(() => {
                    loader.style.display = 'none';
                    paperContainer.classList.remove('opacity-0', 'scale-95');
                    paperContainer.classList.add('animate-appear');
                }, 500);
            }, 1500); // 1.5s simulated delay + load time = "agak lama"
        });

        // --- Visual Cues on Paper ---
        paper.classList.add('cursor-zoom-in', 'group', 'relative');
        const zoomHint = document.getElementById('zoomHint');

        // --- Open Modal ---
        paper.addEventListener('click', () => {
            // Clone content
            zoomContent.innerHTML = '';
            const clone = paper.cloneNode(true);

            // Styling clone for modal
            clone.classList.remove('cursor-zoom-in', 'group', 'relative', 'paper-shadow', 'mb-10', 'mx-auto');
            clone.classList.add('shadow-2xl');
            // Remove w-full from global styles to prevent stretching in flex center
            clone.style.width = '210mm'; // Standard A4 width reference or keep existing class style

            zoomContent.appendChild(clone);

            // Hide main hint
            zoomHint.classList.add('opacity-0');

            // Reset State
            currentScale = 0.5; // Initial zoom 50% as requested
            pannedX = 0;
            pannedY = 0;
            updateTransform(false); // Update without showing the hint immediately on open

            modal.classList.remove('hidden');
            // Little delay for transition flow
            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0');
            });

            document.body.style.overflow = 'hidden'; // Prevent bg scrolling
        });

        // --- Close Modal ---
        function closeZoom() {
            modal.classList.add('opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                zoomContent.innerHTML = '';
                document.body.style.overflow = '';
                // Show hint again
                zoomHint.classList.remove('opacity-0');
            }, 500); // Match transition duration
        }
        closeBtn.addEventListener('click', closeZoom);

        // --- Zoom Helper Functions ---
        function updateTransform(showIndicator = null) {
            // Soft limits
            if (currentScale < 0.3) currentScale = 0.3;
            if (currentScale > 5) currentScale = 5;

            zoomContent.style.transform = `translate(${pannedX}px, ${pannedY}px) scale(${currentScale})`;
            zoomLevelDisplay.textContent = `${Math.round(currentScale * 100)}%`;

            // Default showIndicator is true, unless explicitly false (pan) or null (default logic)
            if (showIndicator !== false) {
                zoomIndicator.classList.remove('opacity-0');
                clearTimeout(zoomTimeout);
                zoomTimeout = setTimeout(() => {
                    zoomIndicator.classList.add('opacity-0');
                }, 1500);
            }
        }

        function zoomBy(factor) {
            zoomContent.style.transition = 'transform 0.2s cubic-bezier(0.25, 1, 0.5, 1)';
            currentScale *= factor;
            updateTransform(true);
            // Remove transition after it's done to stay responsive for drag
            setTimeout(() => { zoomContent.style.transition = 'none'; }, 200);
        }

        // --- Button Controls ---
        document.getElementById('zoomInBtn').addEventListener('click', () => zoomBy(1.2));
        document.getElementById('zoomOutBtn').addEventListener('click', () => zoomBy(0.8));
        document.getElementById('resetZoomBtn').addEventListener('click', () => {
            currentScale = window.innerWidth < 768 ? 0.6 : 0.9;
            pannedX = 0;
            pannedY = 0;
            zoomBy(1); // just trigger update with transition
        });

        // --- Touch & Mouse Gestures (Pinch & Pan) ---
        const container = modal; // Detect events on the whole modal background

        // Handl Tap to Zoom (Click)
        container.addEventListener('click', (e) => {
            if (e.target.closest('button')) return; // Ignore buttons
            if (hasMoved) return; // Ignore if user dragged

            // Toggle Zoom Logic
            zoomContent.style.transition = 'transform 0.3s cubic-bezier(0.25, 1, 0.5, 1)';
            if (currentScale < 1.0) {
                currentScale = 1.5; // Zoom In
            } else {
                currentScale = 0.5; // Zoom Out (Back to initial)
                pannedX = 0; // Reset Position on zoom out
                pannedY = 0;
            }
            updateTransform(true);
            setTimeout(() => { zoomContent.style.transition = 'none'; }, 300);
        });

        // 1. Mouse Drag (Pan)
        container.addEventListener('mousedown', (e) => {
            if (e.target.closest('button')) return; // Ignore buttons
            isDragging = true;
            hasMoved = false; // Reset move flag
            startX = e.clientX - pannedX;
            startY = e.clientY - pannedY;
            container.style.cursor = 'grabbing';
            zoomContent.style.transition = 'none'; // Instant pan
        });

        window.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            e.preventDefault();
            hasMoved = true; // Mark as moved
            pannedX = e.clientX - startX;
            pannedY = e.clientY - startY;
            updateTransform(false); // Don't show zoom indicator on pan
        });

        window.addEventListener('mouseup', () => {
            isDragging = false;
            container.style.cursor = 'default';
        });

        // 2. Touch Events (Pinch & Pan)
        container.addEventListener('touchstart', (e) => {
            if (e.target.closest('button')) return;

            if (e.touches.length === 1) {
                // Formatting for Pan
                isDragging = true;
                hasMoved = false; // Reset move flag
                startX = e.touches[0].clientX - pannedX;
                startY = e.touches[0].clientY - pannedY;
                zoomContent.style.transition = 'none';
            } else if (e.touches.length === 2) {
                // Formatting for Pinch
                isDragging = false; // Disable pan Logic during pinch init
                hasMoved = true; // Pinch counts as move
                lastTouchDistance = getDistance(e.touches);
                zoomContent.style.transition = 'none';
            }
        }, { passive: false });

        container.addEventListener('touchmove', (e) => {
            // If multi-touch or significantly moved, set hasMoved
            // Add threshold to filter out accidental micro-moves on tap
            if (isDragging) {
                const currentX = e.touches[0].clientX;
                const currentY = e.touches[0].clientY;
                if (Math.abs(currentX - (startX + pannedX)) > 5 || Math.abs(currentY - (startY + pannedY)) > 5) {
                    hasMoved = true;
                }
            }

            if (e.target.closest('button')) return;
            // e.preventDefault(); // Prevent browser native zoom/scroll -> moved to specific conditions to allow click? NO, keep it to prevent scroll.

            if (e.touches.length === 1 && isDragging) {
                e.preventDefault();
                // Pan
                pannedX = e.touches[0].clientX - startX;
                pannedY = e.touches[0].clientY - startY;
                updateTransform(false); // No indicator on pan
            } else if (e.touches.length === 2) {
                e.preventDefault();
                // Pinch
                const distance = getDistance(e.touches);
                const delta = distance / lastTouchDistance;

                // Adjust scale relatively
                // We want smooth zoom, so we apply delta directly
                // To make it feel 'followed', we might need center point logic but basic scale is okay for now
                currentScale *= delta;

                lastTouchDistance = distance;
                updateTransform(true); // Show indicator on pinch zoom
            }
        }, { passive: false });

        container.addEventListener('touchend', (e) => {
            isDragging = false;
            // Snap back if out of bounds logic could go here
        });

        function getDistance(touches) {
            const dx = touches[0].clientX - touches[1].clientX;
            const dy = touches[0].clientY - touches[1].clientY;
            return Math.sqrt(dx * dx + dy * dy);
        }

        // --- Wheel Zoom (Desktop) ---
        container.addEventListener('wheel', (e) => {
            e.preventDefault();

            // Determine zoom direction
            if (e.ctrlKey || e.metaKey) {
                // Browser style zoom
                const delta = e.deltaY > 0 ? 0.9 : 1.1;
                currentScale *= delta;
                updateTransform(true);
            } else {
                // Pan/Scroll
                pannedY -= e.deltaY;
                pannedX -= e.deltaX;
                updateTransform(false);
            }
        }, { passive: false });


        // --- Share Logic ---
        document.getElementById('btnShare').addEventListener('click', async () => {
            if (navigator.share) {
                try {
                    await navigator.share({
                        title: 'Laporan Kehadiran Santri',
                        text: 'Laporan kehadiran santri periode {{ now()->translatedFormat("F Y") }}',
                        url: window.location.href,
                    });
                } catch (err) { }
            } else {
                alert('Fitur share tidak didukung di browser ini.');
            }
        });
    </script>
</body>

</html>
