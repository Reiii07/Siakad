<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalKuliahSeeder extends Seeder {
    public function run(): void {
        // Hanya insert jika data jadwal masih kosong
        if (DB::table('jadwal_kuliah')->count() === 0) {
            DB::table('jadwal_kuliah')->insert([
                ['id_mk' => 'MK001', 'nip_dosen' => '198501011985', 'hari' => 'Senin', 'jam_mulai' => '08:00', 'jam_selesai' => '10:00', 'ruangan' => 'Ruang 101'],
                ['id_mk' => 'MK001', 'nip_dosen' => '198501011985', 'hari' => 'Rabu', 'jam_mulai' => '10:00', 'jam_selesai' => '12:00', 'ruangan' => 'Ruang 101'],
                ['id_mk' => 'MK002', 'nip_dosen' => '198502011986', 'hari' => 'Selasa', 'jam_mulai' => '13:00', 'jam_selesai' => '15:00', 'ruangan' => 'Ruang 202'],
                ['id_mk' => 'MK002', 'nip_dosen' => '198502011986', 'hari' => 'Kamis', 'jam_mulai' => '13:00', 'jam_selesai' => '15:00', 'ruangan' => 'Ruang 202'],
            ]);
        }
    }
}
