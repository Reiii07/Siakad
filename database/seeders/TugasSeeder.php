<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TugasSeeder extends Seeder {
    public function run(): void {
        DB::table('tugas')->insert([
            ['id_mk' => 'MK001', 'judul' => 'Membuat CRUD PHP', 'deskripsi' => 'Buatlah koneksi database dan form input.', 'deadline' => '2026-07-10 23:59:00'],
            ['id_mk' => 'MK001', 'judul' => 'Project Laravel', 'deskripsi' => 'Buat aplikasi e-commerce sederhana.', 'deadline' => '2026-07-15 23:59:00'],
            ['id_mk' => 'MK002', 'judul' => 'Machine Learning Model', 'deskripsi' => 'Implementasikan algoritma SVM.', 'deadline' => '2026-07-20 23:59:00'],
        ]);
    }
}