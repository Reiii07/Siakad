<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenSeeder extends Seeder {
    public function run(): void {
        // Hanya insert jika data dosen masih kosong
        if (DB::table('dosen')->count() === 0) {
            DB::table('dosen')->insert([
                ['nip' => '198501012024', 'nama_dosen' => 'Dosen1', 'username' => 'dosen1', 'password' => bcrypt('dosen123')],
                ['nip' => '198601012024', 'nama_dosen' => 'Dosen2', 'username' => 'dosen2', 'password' => bcrypt('dosen123')],
            ]);
        }
    }
}