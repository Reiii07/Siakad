<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AbsensiController extends Controller
{
    public function index(Request $request): View
    {
        $absensiList = Absensi::with(['mahasiswa', 'mataKuliah'])
            ->when($request->filled('filter_mk'), fn ($query) => $query->where('id_mk', $request->query('filter_mk')))
            ->when($request->filled('filter_tgl'), fn ($query) => $query->whereDate('tanggal', $request->query('filter_tgl')))
            ->orderByDesc('tanggal')
            ->orderByDesc('id_absensi')
            ->get();

        $mataKuliahList = MataKuliah::orderBy('nama_mk')->get();
        $mahasiswaList = Mahasiswa::orderBy('nama_mahasiswa')->get();

        return view('admin.absensi', compact('absensiList', 'mataKuliahList', 'mahasiswaList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_mk' => ['required', 'exists:mata_kuliah,id_mk'],
            'nim' => ['required', 'exists:mahasiswa,nim'],
            'tanggal' => ['required', 'date'],
            'status' => ['required', 'in:Hadir,Sakit,Izin,Alfa'],
        ]);

        Absensi::create($validated);

        return redirect()
            ->route('admin.absensi.index')
            ->with('success', 'Absensi berhasil dicatat!');
    }

    public function destroy(Absensi $absensi): RedirectResponse
    {
        $absensi->delete();

        return redirect()
            ->route('admin.absensi.index')
            ->with('success', 'Data absensi berhasil dihapus!');
    }
}
