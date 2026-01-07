<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        // =========================
        // LOGS (TABLE)
        // =========================
        $logs = Activity::with('causer')
            ->latest()
            ->paginate(10);

        // =========================
        // DAILY ACTIVITY (14 HARI)
        // =========================
        $daily = Activity::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(14))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // =========================
        // EVENT COUNT
        // =========================
        $eventCount = Activity::selectRaw('event, COUNT(*) as total')
            ->groupBy('event')
            ->pluck('total', 'event');

        // =========================
        // TOP USERS (AMAN)
        // =========================
        $topUsers = Activity::with('causer')
            ->selectRaw('causer_id, COUNT(*) as total')
            ->groupBy('causer_id')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'name'  => optional($item->causer)->name ?? 'Unknown',
                    'total' => $item->total,
                ];
            });

        // =========================
        // TOP MODELS
        // =========================
        $topModels = Activity::selectRaw('subject_type, COUNT(*) as total')
            ->groupBy('subject_type')
            ->orderByDesc('total')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'model' => class_basename($item->subject_type),
                    'total' => $item->total,
                ];
            });

        return view('activity.index', compact(
            'logs',
            'daily',
            'eventCount',
            'topUsers',
            'topModels'
        ));
    }
}
