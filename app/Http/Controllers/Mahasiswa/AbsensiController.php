<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AbsensiController extends Controller
{
    public function index(Request $request): View
    {
        $nim = $request->session()->get('nim');

        $absensiList = Absensi::with('mataKuliah')
            ->where('nim', $nim)
            ->when($request->filled('filter_mk'), fn ($query) => $query->where('id_mk', $request->query('filter_mk')))
            ->when($request->filled('filter_tgl'), fn ($query) => $query->whereDate('tanggal', $request->query('filter_tgl')))
            ->orderByDesc('tanggal')
            ->orderByDesc('id_absensi')
            ->get();

        $mataKuliahList = MataKuliah::whereIn(
            'id_mk',
            Absensi::where('nim', $nim)->select('id_mk')
        )->orderBy('nama_mk')->get();

        $rekap = [
            'Hadir' => Absensi::where('nim', $nim)->where('status', 'Hadir')->count(),
            'Sakit' => Absensi::where('nim', $nim)->where('status', 'Sakit')->count(),
            'Izin' => Absensi::where('nim', $nim)->where('status', 'Izin')->count(),
            'Alfa' => Absensi::where('nim', $nim)->where('status', 'Alfa')->count(),
        ];

        return view('mahasiswa.absensi', compact('absensiList', 'mataKuliahList', 'rekap'));
    }
}
