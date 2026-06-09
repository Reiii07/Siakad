<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder {
    public function run(): void {
        DB::table('admin')->insert([
            'nama'       => 'Administrator Utama',
            'username'   => 'admin',
            'password'   => bcrypt('admin123'),
        ]);
    }
}