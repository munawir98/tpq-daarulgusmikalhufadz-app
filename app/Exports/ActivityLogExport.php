<?php

namespace App\Exports;

use Spatie\Activitylog\Models\Activity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;

class ActivityLogExport implements FromCollection
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        return Activity::query()
            ->when($this->request->user, function ($q) {
                $q->whereHas('causer', function ($userQuery) {
                    $userQuery->where('name', 'LIKE', '%' . $this->request->user . '%');
                });
            })
            ->when($this->request->event, function ($q) {
                $q->where('event', $this->request->event);
            })
            ->when($this->request->from, function ($q) {
                $q->whereDate('created_at', '>=', $this->request->from);
            })
            ->when($this->request->to, function ($q) {
                $q->whereDate('created_at', '<=', $this->request->to);
            })
            ->latest()
            ->get();
    }
}

