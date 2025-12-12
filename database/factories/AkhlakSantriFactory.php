<?php

namespace Database\Factories;

use App\Models\Santri;
use Illuminate\Database\Eloquent\Factories\Factory;

class AkhlakSantriFactory extends Factory
{
    public function definition(): array
    {
        return [
            'santri_id' => Santri::factory(),
            'disiplin' => rand(1, 5),
            'kerajinan' => rand(1, 5),
            'kesopanan' => rand(1, 5),
            'catatan' => $this->faker->sentence(),
            'tanggal_penilaian' => $this->faker->date(),
        ];
    }
}
