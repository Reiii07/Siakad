<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\JadwalKuliah;
use App\Models\Tugas;
use App\Models\MataKuliah;
use App\Models\Absensi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get nip dari session
        $nip = $request->session()->get('nip');
        
        // Jika session nip tidak ada, coba cari dari username session
        if (!$nip) {
            $username = $request->session()->get('username');
            $dosen = Dosen::where('username', $username)->first();
            $nip = $dosen?->nip;
        }

        // Get dosen data
        $dosen = Dosen::where('nip', $nip)->first() ?? new Dosen();
        
        // Get mata kuliah yang diajar
        $mataKuliahList = MataKuliah::where('nip_dosen', $nip)->get();
        $mata_kuliah_ids = $mataKuliahList->pluck('id_mk')->toArray();

        // Jika tidak ada mata kuliah, initialize empty arrays
        if (empty($mata_kuliah_ids)) {
            $jadwalKuliah = collect();
            $tugas = collect();
            $absensiTerbaru = collect();
            $totalMataKuliah = 0;
            $totalTugas = 0;
            $totalAbsensi = 0;
        } else {
            // Get jadwal mengajar
            $jadwalKuliah = JadwalKuliah::whereIn('id_mk', $mata_kuliah_ids)
                ->with('mataKuliah')
                ->orderBy('jam_mulai')
                ->get();

            // Get daftar tugas
            $tugas = Tugas::whereIn('id_mk', $mata_kuliah_ids)
                ->with('mataKuliah')
                ->orderByDesc('deadline')
                ->limit(10)
                ->get();

            // Get absensi terbaru
            $absensiTerbaru = Absensi::whereIn('id_mk', $mata_kuliah_ids)
                ->with('mataKuliah')
                ->orderByDesc('tanggal')
                ->limit(10)
                ->get();

            // Count statistics
            $totalMataKuliah = count($mata_kuliah_ids);
            $totalTugas = Tugas::whereIn('id_mk', $mata_kuliah_ids)->count();
            $totalAbsensi = Absensi::whereIn('id_mk', $mata_kuliah_ids)->count();
        }

        return view('dosen.dashboard', compact(
            'dosen',
            'jadwalKuliah',
            'tugas',
            'absensiTerbaru',
            'totalMataKuliah',
            'totalTugas',
            'totalAbsensi',
            'mataKuliahList'
        ));
    }
}
