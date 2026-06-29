<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestoreDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert Dosen
        $dosens = [
            ['nip' => '198501011985', 'nama_dosen' => 'Jeffry/Riswandi', 'username' => 'jeffry', 'password' => bcrypt('jeffry')],
            ['nip' => '198502011986', 'nama_dosen' => 'Naili Suri Intizhami', 'username' => 'naili', 'password' => bcrypt('naili')],
            ['nip' => '198503011987', 'nama_dosen' => 'Mardiyah Rafrin', 'username' => 'mardiyah', 'password' => bcrypt('mardiyah')],
            ['nip' => '198504011988', 'nama_dosen' => 'Ahmad Yasim', 'username' => 'ahmad', 'password' => bcrypt('ahmad')],
            ['nip' => '198505011989', 'nama_dosen' => 'Putri Ayu Maharani', 'username' => 'putri', 'password' => bcrypt('putri')],
            ['nip' => '198506011990', 'nama_dosen' => 'Riswandi/Azminuddin', 'username' => 'riswandi', 'password' => bcrypt('riswandi')],
            ['nip' => '198507011991', 'nama_dosen' => 'Muh. Agus', 'username' => 'muagus', 'password' => bcrypt('muagus')],
        ];

        foreach ($dosens as $dosen) {
            DB::table('dosen')->updateOrInsert(['nip' => $dosen['nip']], $dosen);
        }

        // Insert Mata Kuliah
        $mataKuliahs = [
            ['id_mk' => 'MK001', 'nama_mk' => 'Desain dan Analisis Algoritma', 'nip_dosen' => '198501011985'],
            ['id_mk' => 'MK002', 'nama_mk' => 'Kecerdasan Buatan', 'nip_dosen' => '198502011986'],
            ['id_mk' => 'MK003', 'nama_mk' => 'Pemrograman Web', 'nip_dosen' => '198503011987'],
            ['id_mk' => 'MK004', 'nama_mk' => 'Riset Teknologi Informasi', 'nip_dosen' => '198502011986'],
            ['id_mk' => 'MK005', 'nama_mk' => 'Probabilitas dan Statistika', 'nip_dosen' => '198504011988'],
            ['id_mk' => 'MK006', 'nama_mk' => 'Rekayasa Perangkat Lunak', 'nip_dosen' => '198505011989'],
            ['id_mk' => 'MK007', 'nama_mk' => 'Pengolahan Citra Digital', 'nip_dosen' => '198506011990'],
            ['id_mk' => 'MK008', 'nama_mk' => 'Keamanan Data dan Informasi', 'nip_dosen' => '198507011991'],
        ];

        foreach ($mataKuliahs as $mk) {
            if (!DB::table('mata_kuliah')->where('id_mk', $mk['id_mk'])->exists()) {
                DB::table('mata_kuliah')->insert($mk);
            }
        }

        // Insert Jadwal Kuliah
        $jadwals = [
            // Senin
            ['id_mk' => 'MK001', 'nip_dosen' => '198501011985', 'hari' => 'Senin', 'jam_mulai' => '10:40', 'jam_selesai' => '12:10', 'ruangan' => 'LAB.204'],
            ['id_mk' => 'MK002', 'nip_dosen' => '198502011986', 'hari' => 'Senin', 'jam_mulai' => '15:45', 'jam_selesai' => '17:25', 'ruangan' => 'LT-205'],
            // Selasa
            ['id_mk' => 'MK003', 'nip_dosen' => '198503011987', 'hari' => 'Selasa', 'jam_mulai' => '11:00', 'jam_selesai' => '12:40', 'ruangan' => 'LT4-RUANG-01'],
            ['id_mk' => 'MK004', 'nip_dosen' => '198502011986', 'hari' => 'Selasa', 'jam_mulai' => '14:00', 'jam_selesai' => '15:40', 'ruangan' => 'LT-203'],
            ['id_mk' => 'MK005', 'nip_dosen' => '198504011988', 'hari' => 'Selasa', 'jam_mulai' => '15:45', 'jam_selesai' => '17:25', 'ruangan' => 'LT-205'],
            ['id_mk' => 'MK003', 'nip_dosen' => '198503011987', 'hari' => 'Selasa', 'jam_mulai' => '16:40', 'jam_selesai' => '18:10', 'ruangan' => 'LAB.204/205'],
            // Rabu
            ['id_mk' => 'MK001', 'nip_dosen' => '198501011985', 'hari' => 'Rabu', 'jam_mulai' => '09:15', 'jam_selesai' => '10:55', 'ruangan' => 'LT4-RUANG-01'],
            ['id_mk' => 'MK006', 'nip_dosen' => '198505011989', 'hari' => 'Rabu', 'jam_mulai' => '11:00', 'jam_selesai' => '12:40', 'ruangan' => 'LT-201'],
            // Kamis
            ['id_mk' => 'MK007', 'nip_dosen' => '198506011990', 'hari' => 'Kamis', 'jam_mulai' => '14:00', 'jam_selesai' => '15:40', 'ruangan' => 'LT-203'],
            ['id_mk' => 'MK008', 'nip_dosen' => '198507011991', 'hari' => 'Kamis', 'jam_mulai' => '15:45', 'jam_selesai' => '17:25', 'ruangan' => 'LT-201'],
        ];

        foreach ($jadwals as $jadwal) {
            // Cek apakah jadwal dengan kombinasi ini sudah ada
            if (!DB::table('jadwal_kuliah')
                ->where('id_mk', $jadwal['id_mk'])
                ->where('hari', $jadwal['hari'])
                ->where('jam_mulai', $jadwal['jam_mulai'])
                ->exists()) {
                DB::table('jadwal_kuliah')->insert($jadwal);
            } else {
                DB::table('jadwal_kuliah')
                    ->where('id_mk', $jadwal['id_mk'])
                    ->where('hari', $jadwal['hari'])
                    ->where('jam_mulai', $jadwal['jam_mulai'])
                    ->update(['nip_dosen' => $jadwal['nip_dosen']]);
            }
        }
    }
}
