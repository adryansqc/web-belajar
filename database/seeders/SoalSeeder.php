<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Soal; // Pastikan baris ini ada

class SoalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Soal::create([
            'latihan_id' => 1,
            'pertanyaan' => 'Berapakah hasil dari 5 + 3?',
            'pilihan_a' => '7',
            'pilihan_b' => '8',
            'pilihan_c' => '9',
            'pilihan_d' => '10',
            'jawaban_benar' => 'B',
            'waktu_per_soal' => 3600,
        ]);

        Soal::create([
            'latihan_id' => 1,
            'pertanyaan' => 'Jika 12 + 7, berapakah hasilnya?',
            'pilihan_a' => '18',
            'pilihan_b' => '19',
            'pilihan_c' => '20',
            'pilihan_d' => '21',
            'jawaban_benar' => 'B',
            'waktu_per_soal' => 3600,
        ]);

        Soal::create([
            'latihan_id' => 1,
            'pertanyaan' => 'Hitunglah 25 + 15!',
            'pilihan_a' => '30',
            'pilihan_b' => '35',
            'pilihan_c' => '40',
            'pilihan_d' => '45',
            'jawaban_benar' => 'C',
            'waktu_per_soal' => 3600,
        ]);
    }
}
