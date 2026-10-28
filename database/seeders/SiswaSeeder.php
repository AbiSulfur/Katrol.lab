<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'Ahmad Fauzi', 'nis' => '1001', 'ph' => 70, 'pts' => 65, 'pas' => 68],
            ['nama' => 'Siti Nurhaliza', 'nis' => '1002', 'ph' => 85, 'pts' => 88, 'pas' => 82],
            ['nama' => 'Budi Santoso', 'nis' => '1003', 'ph' => 60, 'pts' => 55, 'pas' => 58],
            ['nama' => 'Dewi Lestari', 'nis' => '1004', 'ph' => 90, 'pts' => 92, 'pas' => 88],
            ['nama' => 'Eko Prasetyo', 'nis' => '1005', 'ph' => 72, 'pts' => 70, 'pas' => 68],
            ['nama' => 'Fitri Handayani', 'nis' => '1006', 'ph' => 78, 'pts' => 80, 'pas' => 76],
            ['nama' => 'Gilang Ramadhan', 'nis' => '1007', 'ph' => 58, 'pts' => 62, 'pas' => 54],
            ['nama' => 'Hani Wijaya', 'nis' => '1008', 'ph' => 92, 'pts' => 95, 'pas' => 90],
            ['nama' => 'I Made Artha', 'nis' => '1009', 'ph' => 75, 'pts' => 74, 'pas' => 76],
            ['nama' => 'Joko Supriyadi', 'nis' => '1010', 'ph' => 64, 'pts' => 60, 'pas' => 62],
            ['nama' => 'Kartika Putri', 'nis' => '1011', 'ph' => 82, 'pts' => 84, 'pas' => 80],
            ['nama' => 'Larasati Kusuma', 'nis' => '1012', 'ph' => 88, 'pts' => 85, 'pas' => 86],
        ];

        foreach ($data as $item) {
            Siswa::create($item);
        }
    }
}
