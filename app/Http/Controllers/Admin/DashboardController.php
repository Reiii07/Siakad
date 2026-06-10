<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\MataKuliah;

class DashboardController extends Controller
{
    public function index()
    {
        $total_mhs = Mahasiswa::count();
        $total_dosen = Dosen::count();
        $total_mk = MataKuliah::count();

        $mahasiswa = Mahasiswa::select(
            'nim',
            'nama_mahasiswa',
            'username'
        )->get();

        return view('admin.dashboard', compact(
            'total_mhs',
            'total_dosen',
            'total_mk',
            'mahasiswa'
        ));
    }
}