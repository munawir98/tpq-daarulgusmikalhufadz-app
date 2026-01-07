<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ActivityLogVerification;
use App\Models\User;
use Illuminate\Support\Str;

class ActivityLogVerificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            $this->command->warn('Seeder ActivityLogVerification dibatalkan: tabel users kosong.');
            return;
        }

        ActivityLogVerification::create([
            'hash'         => Str::uuid(),
            'file_name'    => 'laporan-activity-santri-desember-2025.pdf',
            'generated_by' => $user->id,
            'generated_at' => now(),
        ]);
    }
}
