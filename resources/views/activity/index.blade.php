{{-- =============================================== --}}
{{-- ACTIVITY LOG - PREMIUM UI + CHARTS PRO --}}
{{-- =============================================== --}}
<x-layout title="Activity Logs">

    {{-- ===================================================== --}}
    {{-- =============== CHARTS PRO SECTION =============== --}}
    {{-- ===================================================== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

        {{-- DAILY LINE CHART --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-5">
            <h3 class="text-lg font-semibold mb-3 dark:text-gray-200">Aktivitas 14 Hari Terakhir</h3>
            <canvas id="dailyChart" height="140"></canvas>
        </div>

        {{-- EVENT DONUT CHART --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-5">
            <h3 class="text-lg font-semibold mb-3 dark:text-gray-200">Event Breakdown</h3>
            <canvas id="eventChart" height="140"></canvas>
        </div>

        {{-- TOP USERS CHART --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-5">
            <h3 class="text-lg font-semibold mb-3 dark:text-gray-200">Top Users</h3>
            <canvas id="userChart" height="140"></canvas>
        </div>

        {{-- TOP MODELS --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-5">
            <h3 class="text-lg font-semibold mb-3 dark:text-gray-200">Model Paling Banyak Diubah</h3>
            <canvas id="modelChart" height="140"></canvas>
        </div>

    </div>

    {{-- =========================== --}}
    {{-- FILTER CARD PRO --}}
    {{-- =========================== --}}
    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-5 mb-6">

        <h2 class="text-lg font-semibold mb-4 dark:text-gray-200 flex items-center gap-2">
            Filter Activity
        </h2>

        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <div>
                <label class="text-sm text-gray-500 dark:text-gray-400">User</label>
                <input type="text" name="user" class="input-pro" value="{{ request('user') }}">
            </div>

            <div>
                <label class="text-sm text-gray-500 dark:text-gray-400">Event</label>
                <select name="event" class="input-pro">
                    <option value="">Semua Event</option>
                    <option value="created" @selected(request('event')=='created' )>Created</option>
                    <option value="updated" @selected(request('event')=='updated' )>Updated</option>
                    <option value="deleted" @selected(request('event')=='deleted' )>Deleted</option>
                </select>
            </div>

            <div>
                <label class="text-sm text-gray-500 dark:text-gray-400">From</label>
                <input type="date" name="from" class="input-pro" value="{{ request('from') }}">
            </div>

            <div>
                <label class="text-sm text-gray-500 dark:text-gray-400">To</label>
                <input type="date" name="to" class="input-pro" value="{{ request('to') }}">
            </div>

            <div class="md:col-span-4 flex justify-end mt-2">
                <button class="btn-primary flex items-center gap-2">
                    Terapkan Filter
                </button>
            </div>

        </form>
    </div>

    {{-- =========================== --}}
    {{-- EXPORT BUTTONS --}}
    {{-- =========================== --}}
    <div class="flex justify-end gap-3 mb-4">

        <a href="{{ route('activity.export.excel', request()->query()) }}"
            class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow">
            Excel
        </a>

        <a href="{{ route('activity.export.csv', request()->query()) }}"
            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
            CSV
        </a>

        <a href="{{ route('activity.export.pdf', request()->query()) }}"
            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow">
            PDF
        </a>

    </div>

    {{-- =========================== --}}
    {{-- TABLE LOG PRO --}}
    {{-- =========================== --}}
    <div
        class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm overflow-hidden">

        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                <tr>
                    <th class="th-pro">User</th>
                    <th class="th-pro">Event</th>
                    <th class="th-pro">Description</th>
                    <th class="th-pro">Model</th>
                    <th class="th-pro">Time</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @foreach ($logs as $log)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">

                    <td class="td-pro">{{ $log->causer->name ?? '-' }}</td>

                    <td class="td-pro">
                        @php
                        $color = match($log->event) {
                        'created' => 'bg-green-100 text-green-700',
                        'updated' => 'bg-blue-100 text-blue-700',
                        'deleted' => 'bg-red-100 text-red-700',
                        default => 'bg-gray-200 text-gray-600',
                        };
                        @endphp
                        <span class="badge-pro {{ $color }}">{{ $log->event }}</span>
                    </td>

                    <td class="td-pro">{{ $log->description }}</td>

                    <td class="td-pro">{{ class_basename($log->subject_type) }}</td>

                    <td class="td-pro">{{ $log->created_at }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4">
            {{ $logs->links() }}
        </div>

    </div>

    {{-- =========================== --}}
    {{-- STYLE PRO --}}
    {{-- =========================== --}}
    <style>
        .input-pro {
            @apply w-full px-3 py-2 rounded-lg bg-gray-100 dark:bg-gray-800 border border-gray-300 dark:border-gray-700;
        }

        .btn-primary {
            @apply px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow;
        }

        .th-pro {
            @apply px-4 py-3 text-left font-semibold;
        }

        .td-pro {
            @apply px-4 py-3 dark:text-gray-200;
        }

        .badge-pro {
            @apply px-2 py-1 rounded-lg text-xs font-semibold;
        }
    </style>

    {{-- =========================== --}}
    {{-- CHART SCRIPT (FIXED) --}}
    {{-- =========================== --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // DAILY CHART
        new Chart(document.getElementById('dailyChart'), {
            type: 'line',
            data: {
                labels: @json($daily -> pluck('date')),
                datasets: [{
                    data: @json($daily -> pluck('total')),
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37,99,235,0.3)',
                    tension: 0.35,
                    fill: true
                }]
            }
        });

        // EVENT DONUT CHART
        new Chart(document.getElementById('eventChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(@json($eventCount)),
                datasets: [{
                    data: Object.values(@json($eventCount)),
                    backgroundColor: ['#22c55e', '#2563eb', '#dc2626']
                }]
            }
        });

        // TOP USERS (FIXED → ambil relasi causer.name)
        new Chart(document.getElementById('userChart'), {
            type: 'bar',
            data: {
                labels: @json($topUsers -> pluck('causer.name')),
                datasets: [{
                    data: @json($topUsers -> pluck('total')),
                    backgroundColor: '#2563eb'
                }]
            },
            options: { indexAxis: 'y' }
        });

        // TOP MODELS (FIXED → subject_type)
        new Chart(document.getElementById('modelChart'), {
            type: 'bar',
            data: {
                labels: @json($topModels -> pluck('subject_type')),
                datasets: [{
                    data: @json($topModels -> pluck('total')),
                    backgroundColor: '#7c3aed'
                }]
            }
        });
    </script>

</x-layout>
