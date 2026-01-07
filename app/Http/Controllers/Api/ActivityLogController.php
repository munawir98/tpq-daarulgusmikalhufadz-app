<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Helpers\ApiResponse;

// EXPORT
use App\Exports\ActivityLogExport;
use Maatwebsite\Excel\Facades\Excel;

// PDF & QR
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ActivityLogController extends Controller
{
    /**
     * GET /activity-logs
     * List + filter activity logs
     */
    public function index(Request $request)
    {
        $perPage = $request->integer('per_page', 15);

        $query = Activity::with('causer:id,name')->latest();

        // 🔐 Role-based access
        $user = auth()->user();
        if ($user->role !== 'ADMIN') {
            $query->where('causer_id', $user->id);
        }

        // 🔎 Filters
        if ($request->filled('user_id')) {
            $query->where('causer_id', $request->user_id);
        }

        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        if ($request->filled('module')) {
            $query->where('subject_type', 'LIKE', '%' . $request->module . '%');
        }

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $logs = $query->paginate($perPage);

        $logs->getCollection()->transform(function ($log) {
            return [
                'id'          => $log->id,
                'event'       => $log->event,
                'description' => $log->description,
                'module'      => $this->moduleName($log->subject_type),
                'user'        => optional($log->causer)->name,
                'created_at'  => $log->created_at->format('Y-m-d H:i'),
            ];
        });

        return ApiResponse::paginate($logs, 'Activity logs fetched');
    }

    /**
     * GET /activity-logs/summary
     * Cached + Role-aware + Flutter-ready
     */
    public function summary()
    {
        $user = auth()->user();
        $role = $user->role === 'ADMIN' ? 'ADMIN' : 'USER';

        $cacheKey = "activity_log_summary_{$role}_{$user->id}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($user, $role) {

            $startDate = now()->subDays(13)->startOfDay();
            $endDate   = now()->endOfDay();

            $baseQuery = Activity::query()
                ->whereBetween('created_at', [$startDate, $endDate]);

            if ($role !== 'ADMIN') {
                $baseQuery->where('causer_id', $user->id);
            }

            // Line chart
            $daily = $baseQuery->clone()
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            // Event chart
            $events = $baseQuery->clone()
                ->select('event', DB::raw('COUNT(*) as total'))
                ->groupBy('event')
                ->get();

            // Top users (ADMIN only)
            $topUsers = [];
            if ($role === 'ADMIN') {
                $topUsers = Activity::select('causer_id', DB::raw('COUNT(*) as total'))
                    ->whereNotNull('causer_id')
                    ->groupBy('causer_id')
                    ->with('causer:id,name')
                    ->orderByDesc('total')
                    ->limit(5)
                    ->get();
            }

            // Top modules
            $topModules = $baseQuery->clone()
                ->select('subject_type', DB::raw('COUNT(*) as total'))
                ->groupBy('subject_type')
                ->orderByDesc('total')
                ->limit(5)
                ->get()
                ->map(fn ($row) => [
                    'module' => $this->moduleName($row->subject_type),
                    'total'  => (int) $row->total,
                ]);

            return ApiResponse::success([
                'daily'      => $daily,
                'events'     => $events,
                'topUsers'   => $topUsers,
                'topModules' => $topModules,
                'role'       => $role,
            ], 'Activity summary fetched');
        });
    }

    /**
     * EXPORT EXCEL
     */
    public function exportExcel(Request $request)
    {
        return Excel::download(
            new ActivityLogExport($request),
            'activity-log-' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    /**
     * EXPORT CSV
     */
    public function exportCsv(Request $request)
    {
        return Excel::download(
            new ActivityLogExport($request),
            'activity-log-' . now()->format('Ymd_His') . '.csv',
            \Maatwebsite\Excel\Excel::CSV
        );
    }

    /**
     * EXPORT PDF (ENTERPRISE FINAL)
     */
    public function exportPdf(Request $request)
{
    $user = auth()->user();
    $userName = $user->name;

    $query = Activity::with('causer:id,name');

    if ($user->role !== 'ADMIN') {
        $query->where('causer_id', $user->id);
    }

    if ($request->filled('from')) {
        $query->whereDate('created_at', '>=', $request->from);
    }

    if ($request->filled('to')) {
        $query->whereDate('created_at', '<=', $request->to);
    }

    $logs = $query->latest()->get()->map(function ($log) {
        return [
            'tanggal' => $log->created_at->format('d-m-Y H:i'),
            'user'    => optional($log->causer)->name,
            'event'   => strtoupper($log->event),
            'module'  => $this->moduleName($log->subject_type),
            'desc'    => $log->description,
        ];
    });

    // 📄 Nama file
    $fileName = 'activity-log-' . now()->format('Ymd_His') . '.pdf';

    // 🔗 DATA QR → URL VERIFIKASI
    $qrData = route('activity-log.verify', [
        'hash' => sha1($fileName),
    ]);

    // 🔲 QR CODE (BASE64)
    $qrCode = base64_encode(
        QrCode::format('png')->size(120)->generate($qrData)
    );

    // 🧾 Generate PDF
    $pdf = Pdf::loadView('pdf.activity-log', [
        'logs' => $logs,
        'user' => $userName,
        'date' => now()->format('d F Y H:i'),
        'qr'   => $qrCode,
    ])->setPaper('A4', 'portrait');

    return $pdf->download($fileName);
}


    /**
     * subject_type → module name
     */
    private function moduleName(?string $subjectType): string
    {
        if (!$subjectType) return 'Lainnya';

        $map = [
            'Santri'    => 'Santri',
            'Presensi' => 'Presensi',
            'Infaq'    => 'Infaq',
            'Nilai'    => 'Nilai',
            'Akhlak'   => 'Akhlak',
            'Gaji'     => 'Gaji',
            'Chat'     => 'Chat',
            'Kelas'    => 'Kelas',
            'Ustadz'   => 'Ustadz',
            'Pengajar' => 'Pengajar',
            'Jadwal'   => 'Jadwal',
        ];

        foreach ($map as $key => $label) {
            if (str_contains($subjectType, $key)) {
                return $label;
            }
        }

        return 'Lainnya';
    }
}
