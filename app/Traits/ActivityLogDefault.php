<?php

namespace App\Traits;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

trait ActivityLogDefault
{
    use LogsActivity;

    /**
     * Default Activity Log untuk semua model.
     * - logAll() → mencatat semua kolom
     * - logOnlyDirty() → hanya kolom yang berubah
     * - dontSubmitEmptyLogs() → tidak log jika tidak ada perubahan
     * - useLogName() → nama log default berdasarkan nama model
     * - setDescriptionForEvent() → deskripsi default,
     *   model dapat menimpa (override) untuk custom description.
     */
    public function getActivitylogOptions(): LogOptions
    {
        $modelName = class_basename($this);               // contoh: Santri, User, Ustadz
        $actorName = auth()->user()->name ?? 'Sistem';    // siapa yang melakukan aksi

        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName(strtolower($modelName))
            ->setDescriptionForEvent(function (string $eventName) use ($modelName, $actorName) {

                // Template default jika model tidak override
                return match ($eventName) {
                    'created' => "{$actorName} membuat {$modelName}",
                    'updated' => "{$actorName} memperbarui {$modelName}",
                    'deleted' => "{$actorName} menghapus {$modelName}",
                    default   => "{$actorName} melakukan perubahan pada {$modelName}",
                };
            });
    }
}
