<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;

class ActivityLogController extends Controller
{
    /**
     * GET /activity-logs
     */
    public function index(Request $request)
    {
        $logs = Activity::with('causer:id,name')
            ->latest()
            ->paginate(15);

        $daily = Activity::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', now()->subDays(14))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $eventCount = [
            'created' => Activity::where('event', 'created')->count(),
            'updated' => Activity::where('event', 'updated')->count(),
            'deleted' => Activity::where('event', 'deleted')->count(),
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

        return response()->json([
            'logs' => $logs,
            'daily' => $daily,
            'eventCount' => $eventCount,
            'topUsers' => $topUsers,
            'topModels' => $topModels,
        ]);
    }

    /**
     * GET /activity-summary
     */
    public function summary()
    {
        $dates = collect();
        for ($i = 13; $i >= 0; $i--) {
            $dates->push(now()->subDays($i)->format('Y-m-d'));
        }

        $activityCounts = $dates->map(function ($date) {
            return Activity::whereDate('created_at', $date)->count();
        });

        return response()->json([
            'labels' => $dates,
            'series' => [
                [
                    'name' => 'Aktivitas',
                    'data' => $activityCounts,
                ],
            ],
            'breakdown' => [
                'created' => Activity::where('event', 'created')->count(),
                'updated' => Activity::where('event', 'updated')->count(),
                'deleted' => Activity::where('event', 'deleted')->count(),
            ],
        ]);
    }
}
