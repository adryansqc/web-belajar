<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LatihanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $latihans = [
            [
                'nama' => 'Latihan 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        foreach ($latihans as $latihan) {
            \App\Models\Latihan::create($latihan);
        }
    }
}
