<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ActivityLogExport;
use Barryvdh\DomPDF\Facade\Pdf;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = Activity::with('causer')->latest()->paginate(15);

        $daily = Activity::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subDays(14))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $eventCount = [
            'created' => Activity::whereEvent('created')->count(),
            'updated' => Activity::whereEvent('updated')->count(),
            'deleted' => Activity::whereEvent('deleted')->count()
        ];

        $topUsers = Activity::select('causer_id', DB::raw('COUNT(*) as total'))
            ->whereNotNull('causer_id')
            ->groupBy('causer_id')
            ->with('causer:id,name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $topModels = Activity::select('subject_type', DB::raw('COUNT(*) as total'))
            ->whereNotNull('subject_type')
            ->groupBy('subject_type')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('activity.index', compact('logs','daily','eventCount','topUsers','topModels'));
    }

    public function excel(Request $request)
    {
        return Excel::download(new ActivityLogExport($request), 'activity_log.xlsx');
    }

    public function csv(Request $request)
    {
        return Excel::download(new ActivityLogExport($request), 'activity_log.csv');
    }

    public function pdf(Request $request)
    {
        $logs = $this->filterQuery($request)->get();

        $pdf = Pdf::loadView('activity.pdf', compact('logs'));
        return $pdf->download('activity_log.pdf');
    }

    private function filterQuery($request)
    {
        return Activity::query()
            ->when($request->user, function ($q) use ($request) {
                $q->whereHas('causer', function ($userQuery) use ($request) {
                    $userQuery->where('name', 'LIKE', '%' . $request->user . '%');
                });
            })
            ->when($request->event, function ($q) use ($request) {
                $q->where('event', $request->event);
            })
            ->when($request->from, function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->from);
            })
            ->when($request->to, function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->to);
            })
            ->latest();
    }


    // ===========================================
    // 📌 NEW: API untuk ringkasan aktivitas 14 hari
    // ===========================================
    public function activitySummary()
    {
        // Ambil 14 hari terakhir (including today)
        $dates = collect();
        for ($i = 13; $i >= 0; $i--) {
            $dates->push(now()->subDays($i)->format('Y-m-d'));
        }

        // Hitung jumlah aktivitas per hari
        $activityCounts = $dates->map(function ($date) {
            return Activity::whereDate('created_at', $date)->count();
        });

        // Breakdown event
        $created = Activity::where('event', 'created')->count();
        $updated = Activity::where('event', 'updated')->count();
        $deleted = Activity::where('event', 'deleted')->count();

        return response()->json([
            "labels" => $dates,
            "series" => [
                [
                    "name" => "Aktivitas",
                    "data" => $activityCounts,
                ]
            ],
            "breakdown" => [
                "created" => $created,
                "updated" => $updated,
                "deleted" => $deleted,
            ]
        ]);
    }

}
