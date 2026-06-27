<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Mahasiswa;
use App\Models\Pengumpulan;
use App\Models\Tugas;
use App\Models\JadwalKuliah; 
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $nim = $request->session()->get('nim');
        $mahasiswa = Mahasiswa::where('nim', $nim)->firstOrFail();

        $totalAbsensi = Absensi::where('nim', $nim)->count();
        $totalHadir = Absensi::where('nim', $nim)->where('status', 'Hadir')->count();
        $totalTugas = Tugas::count();
        $totalDikumpulkan = Pengumpulan::where('nim', $nim)->count();

        $absensiTerbaru = Absensi::with('mataKuliah')
            ->where('nim', $nim)
            ->latest('tanggal')
            ->take(5)
            ->get();

        $pengumpulan = Pengumpulan::where('nim', $nim)
            ->get()
            ->keyBy('id_tugas');

        $tugas = Tugas::with('mataKuliah')
            ->orderBy('deadline')
            ->get()
            ->map(function (Tugas $tugas) use ($pengumpulan) {
                $tugas->pengumpulan_mahasiswa = $pengumpulan->get($tugas->id_tugas);
                return $tugas;
            });

        $jadwalKuliah = JadwalKuliah::with(['mataKuliah.dosen'])
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('mahasiswa.dashboard', compact(
            'mahasiswa',
            'totalAbsensi',
            'totalHadir',
            'totalTugas',
            'totalDikumpulkan',
            'absensiTerbaru',
            'tugas',
            'jadwalKuliah'
        ));
    }
}