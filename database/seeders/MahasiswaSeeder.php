<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder {
    public function run(): void {
        DB::table('mahasiswa')->insert([
            ['nim' => '241011065', 'nama_mahasiswa' => 'Dzul Kifly Rustam',      'username' => '241011065', 'password' => bcrypt('241011065')],
            ['nim' => '241011066', 'nama_mahasiswa' => 'Ridwan Azhari Bakri',    'username' => '241011066', 'password' => bcrypt('241011066')],
            ['nim' => '241011071', 'nama_mahasiswa' => 'Syailendra',             'username' => '241011071', 'password' => bcrypt('241011071')],
            ['nim' => '241011072', 'nama_mahasiswa' => 'Rhere Frendra Saputra',  'username' => '241011072', 'password' => bcrypt('241011072')],
            ['nim' => '241011102', 'nama_mahasiswa' => 'Rezki Haedil Safitrah', 'username' => '241011102', 'password' => bcrypt('241011102')],
        ]);
    }
}