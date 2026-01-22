<?php

use App\Models\User;
use App\Models\Ustadz;

echo "=== BACKFILL NIP START ===\n";

$users = User::where('role', 'USTADZ')
    ->whereNull('nip')
    ->orderBy('created_at', 'asc')
    ->get();

echo "Found " . $users->count() . " Ustadz without NIP.\n";

$year = date('y');
$month = date('m');
$prefix = "{$year}{$month}1"; // 26011...

// Find last used sequence to continue from
$lastUser = User::where('role', 'USTADZ')
    ->where('nip', 'like', "{$prefix}%")
    ->orderBy('nip', 'desc')
    ->first();

$sequence = 1;
if ($lastUser) {
    echo "Last existing NIP: {$lastUser->nip}\n";
    $sequence = intval(substr($lastUser->nip, -3)) + 1;
}

foreach ($users as $u) {
    $newNip = $prefix . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    echo "Updating {$u->name} (ID: {$u->id}) -> NIP: $newNip\n";

    $u->nip = $newNip;
    $u->save();

    // Also update/create Ustadz Profile if needed
    $profile = Ustadz::firstOrCreate(
        ['user_id' => $u->id],
        [
            'nama' => $u->name,
            'status_aktif' => true,
            'nik' => $newNip // Fallback NIK usually
        ]
    );

    // If profile exists but has no NIP, sync it (if needed? schema doesn't seem to have nip on Profile based on controller code, but let's check debug output earlier.
    // Earlier debug output verify_santri_data.php: "NIP (Profile): NULL".
    // Wait, Schema might check column 'nip' in 'ustadz' table?
    // Let's assume User->nip is the source of truth for now based on AuthController.
    // But verify_santri_data checks $profile->nip.
    // If Ustadz model has 'nip', we should update it too.

    if (Schema::hasColumn('ustadz', 'nip')) {
        $profile->nip = $newNip;
        $profile->save();
        echo "  -> Linked Profile NIP updated.\n";
    }

    $sequence++;
}

echo "=== BACKFILL COMPLETE ===\n";
