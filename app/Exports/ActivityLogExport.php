<?php

namespace App\Exports;

use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ActivityLogExport implements FromCollection, WithHeadings
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        return Activity::with('causer')
            ->when($this->request->filled('user'), function ($q) {
                $q->whereHas('causer', function ($u) {
                    $u->where('name', 'LIKE', '%' . $this->request->user . '%');
                });
            })
            ->when($this->request->filled('event'), function ($q) {
                $q->where('event', $this->request->event);
            })
            ->when($this->request->filled('module'), function ($q) {
                $q->where('subject_type', 'LIKE', '%' . $this->request->module . '%');
            })
            ->when($this->request->filled('from'), function ($q) {
                $q->whereDate('created_at', '>=', $this->request->from);
            })
            ->when($this->request->filled('to'), function ($q) {
                $q->whereDate('created_at', '<=', $this->request->to);
            })
            ->latest()
            ->get()
            ->map(function ($log) {
                return [
                    'Tanggal'   => $log->created_at->format('Y-m-d H:i'),
                    'User'      => optional($log->causer)->name,
                    'Event'     => $log->event,
                    'Module'    => $this->moduleName($log->subject_type),
                    'Deskripsi' => $log->description,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'User',
            'Event',
            'Module',
            'Deskripsi',
        ];
    }

    /**
     * Mapping subject_type -> module name
     */
    private function moduleName(?string $subjectType): string
    {
        if (!$subjectType) {
            return 'Lainnya';
        }

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
