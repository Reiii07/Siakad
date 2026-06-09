<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TugasSeeder extends Seeder {
    public function run(): void {
        DB::table('tugas')->insert([
            ['id_mk' => 'MK001', 'judul' => 'Membuat CRUD PHP', 'deskripsi' => 'Buatlah koneksi database dan form input.', 'deadline' => '2026-05-10 23:59:00'],
        ]);
    }
}