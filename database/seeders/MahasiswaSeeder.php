<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder {
    public function run(): void {
        DB::table('mahasiswa')->insert([
            ['nim' => '241011065', 'nama_mahasiswa' => 'Dzul Kifly Rustam',      'username' => 'Dzul Kifly Rustam', 'password' => bcrypt('241011065')],
            ['nim' => '241011066', 'nama_mahasiswa' => 'Ridwan Azhari Bakri',    'username' => 'Ridwan Azhari Bakri', 'password' => bcrypt('241011066')],
            ['nim' => '241011071', 'nama_mahasiswa' => 'Syailendra',             'username' => 'Syailendra', 'password' => bcrypt('241011071')],
            ['nim' => '241011072', 'nama_mahasiswa' => 'Rhere Frendra Saputra',  'username' => 'Rhere Frendra Saputra', 'password' => bcrypt('241011072')],
            ['nim' => '241011102', 'nama_mahasiswa' => 'Rezki Haedil Safitrah', 'username' => 'Rezki Haedil Safitrah', 'password' => bcrypt('241011102')],
        ]);
    }
}
