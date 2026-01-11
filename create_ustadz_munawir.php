<?php

use App\Models\User;
use App\Models\Ustadz;
use Illuminate\Support\Facades\Hash;

$email = 'munawir@ustadz.com';
$password = '12345678';

// 1. Create User
$user = User::firstOrCreate(
    ['email' => $email],
    [
        'name' => 'Ustadz Munawir',
        'password' => Hash::make($password),
        'role' => 'USTADZ',
        'nip' => date('ym') . '1001', // Example NIP
        'status' => 'AKTIF'
    ]
);

// 2. Create Ustadz Profile
$ustadz = Ustadz::firstOrCreate(
    ['user_id' => $user->id],
    [
        'nama' => $user->name,
        'nik' => '1234567890123456',
        'jenis_kelamin' => 'L',
        'no_hp' => '08123456789',
        'alamat' => 'Alamat Default',
        'tanggal_mulai_mengajar' => now(),
        'status_aktif' => true
    ]
);

echo "SUCCESS: Created Ustadz Munawir (ID: " . $ustadz->id . ")";
