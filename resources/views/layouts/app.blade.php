<x-layout title="Activity Log">

    <div x-data="realtimeLog()" class="space-y-6">

        <!-- ======================= -->
        <!-- FILTER BAR -->
        <!-- ======================= -->
        <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">

            <form class="grid grid-cols-1 md:grid-cols-5 gap-4">

                <input type="text" name="user" value="{{ request('user') }}" placeholder="Filter User"
                    class="p-2 rounded bg-gray-100 dark:bg-gray-700 dark:text-white">

                <select name="event" class="p-2 rounded bg-gray-100 dark:bg-gray-700 dark:text-white">
                    <option value="">Event</option>
                    <option value="created">Created</option>
                    <option value="updated">Updated</option>
                    <option value="deleted">Deleted</option>
                </select>

                <input type="date" name="from" class="p-2 rounded bg-gray-100 dark:bg-gray-700 dark:text-white">

                <input type="date" name="to" class="p-2 rounded bg-gray-100 dark:bg-gray-700 dark:text-white">

                <button class="bg-[--theme-color] text-white p-2 rounded hover:opacity-90">
                    Filter
                </button>

            </form>

        </div>


        <!-- ======================= -->
        <!-- FLOWBITE TABLE -->
        <!-- ======================= -->
        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">

            <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">

                <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3">User</th>
                        <th class="px-4 py-3">Event</th>
                        <th class="px-4 py-3">Description</th>
                        <th class="px-4 py-3">Model</th>
                        <th class="px-4 py-3">Time</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>

                <tbody class="divide-y dark:divide-gray-700">

                    <!-- REALTIME ROW -->
                    <template x-for="log in logs" :key="log.id">
                        <tr class="bg-yellow-100 dark:bg-yellow-700 animate-pulse">

                            <td class="px-4 py-3" x-text="log.causer?.name ?? '-'"></td>

                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded text-white" :class="{
                                    'bg-green-600': log.event === 'created',
                                    'bg-blue-600': log.event === 'updated',
                                    'bg-red-600': log.event === 'deleted'
                                }" x-text="log.event"></span>
                            </td>

                            <td class="px-4 py-3" x-text="log.description"></td>
                            <td class="px-4 py-3" x-text="log.subject_type"></td>
                            <td class="px-4 py-3" x-text="log.created_at"></td>
                            <td class="px-4 py-3 text-[--theme-color] font-semibold">LIVE</td>

                        </tr>
                    </template>


                    <!-- STATIC LOGS -->
                    @foreach ($logs as $log)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">

                        <td class="px-4 py-3">{{ $log->causer->name ?? '-' }}</td>

                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-white
                        @if($log->event=='created') bg-green-600
                        @elseif($log->event=='updated') bg-blue-600
                        @else bg-red-600 @endif">
                                {{ $log->event }}
                            </span>
                        </td>

                        <td class="px-4 py-3">{{ $log->description }}</td>

                        <td class="px-4 py-3">{{ class_basename($log->subject_type) }}</td>

                        <td class="px-4 py-3">{{ $log->created_at }}</td>

                        <td class="px-4 py-3">
                            <button data-modal-target="modal-{{ $log->id }}" data-modal-toggle="modal-{{ $log->id }}"
                                class="text-[--theme-color] hover:underline">
                                Detail
                            </button>
                        </td>

                    </tr>
                    @endforeach

                </tbody>
            </table>

            <div class="p-4">{{ $logs->links() }}</div>
        </div>




        <!-- ======================= -->
        <!-- FLOWBITE MODAL DETAIL -->
        <!-- ======================= -->
        @foreach ($logs as $log)
        <div id="modal-{{ $log->id }}" tabindex="-1" aria-hidden="true"
            class="hidden fixed inset-0 z-[9999] flex justify-center items-center bg-black/40 backdrop-blur-sm">

            <div class="relative p-4 w-full max-w-lg">

                <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow p-6">

                    <h3 class="text-lg font-bold dark:text-white mb-4">Activity Detail</h3>

                    <p><b>User:</b> {{ $log->causer->name ?? '-' }}</p>
                    <p><b>IP:</b> {{ $log->properties['ip'] ?? '-' }}</p>
                    <p><b>User Agent:</b> {{ $log->properties['agent'] ?? '-' }}</p>

                    @if(isset($log->properties['old']))
                    <hr class="my-3 dark:border-gray-600">

                    <h4 class="font-semibold dark:text-white mb-2">Changes:</h4>

                    @foreach ($log->properties['old'] as $field => $value)
                    <p class="text-sm dark:text-gray-300">
                        <b>{{ $field }}</b>: "{{ $value }}" → "{{ $log->properties['attributes'][$field] }}"
                    </p>
                    @endforeach
                    @endif

                    <div class="mt-4 text-right">
                        <button data-modal-hide="modal-{{ $log->id }}"
                            class="px-4 py-2 rounded bg-[--theme-color] text-white">
                            Close
                        </button>
                    </div>

                </div>

            </div>

        </div>
        @endforeach


    </div>


    <!-- ======================= -->
    <!-- REALTIME LISTENER -->
    <!-- ======================= -->
    <script>
        function realtimeLog() {
            return {
                logs: [],
                init() {
                    if (window.Echo) {
                        window.Echo.channel('activity-log')
                            .listen('ActivityLogged', (e) => {

                                this.logs.unshift(e.log);

                                // KIRIM TOAST
                                window.dispatchEvent(new CustomEvent('notify', {
                                    detail: { message: e.log.description, type: e.log.event }
                                }));

                            });
                    }
                }
            }
        }
    </script>

</x-layout>
