<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // User admin default
    \App\Models\User::firstOrCreate(
        ['email' => 'santrineumi@gmail.com'],
        [
            'name' => 'Admin TPQ Daarul Gusmik Al-Hufadz',
            'password' => Hash::make('20101996'),
            'role' => 'admin',
        ]
    );

    $this->call([
        UstadzSeeder::class,
        KelasSeeder::class,
        SantriSeeder::class,
        JadwalMengajarSeeder::class,
    ]);
}

}
