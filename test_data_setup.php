<?php

use App\Models\User;
use App\Models\Ustadz;
use App\Models\Kelas;
use App\Models\Santri;

$email = 'ustadz_real@tpq.test';
$user = User::where('email', $email)->first();

if (!$user) {
    echo "User not found: $email\n";
    exit(1);
}

$ustadz = Ustadz::where('user_id', $user->id)->first();
if (!$ustadz) {
    echo "Ustadz profile not found for user: $email\n";
    exit(1);
}

// Create or Get Class
$kelas = Kelas::firstOrCreate(
    ['ustadz_id' => $ustadz->id],
    [
        'kode_kelas' => 'CLS-TEST',
        'nama_kelas' => 'Kelas Testing',
        'tipe' => 'pagi',
        'tingkat' => 'jilid_1',
        'status' => 'aktif',
    ]
);

echo "Class assigned: {$kelas->nama_kelas}\n";

// Create or Get Santri
$santriUser = User::firstOrCreate(
    ['email' => 'santri_test@tpq.test'],
    [
        'name' => 'Santri Testing',
        'password' => bcrypt('password'),
        'role' => 'SANTRI',
        'nis' => 'TEST-001',
    ]
);

$santri = Santri::firstOrCreate(
    ['user_id' => $santriUser->id],
    [
        'nis' => 'TEST-001',
        'nama_lengkap' => 'Santri Testing',
        'nama_panggilan' => 'Santri',
        'jenis_kelamin' => 'L',
        'status_aktif' => true,
        'kelas_id' => $kelas->id,
    ]
);

echo "Santri assigned: {$santri->nama_lengkap}\n";
