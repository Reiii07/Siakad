<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dosen\Concerns\ResolvesDosen;
use App\Models\Absensi;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AbsensiController extends Controller
{
    use ResolvesDosen;

    public function index(Request $request): View
    {
        $dosen = $this->currentDosen($request);
        $mataKuliahList = MataKuliah::where('nip_dosen', $dosen->nip)->orderBy('nama_mk')->get();
        $mataKuliahIds = $mataKuliahList->pluck('id_mk');

        $absensiList = Absensi::with(['mahasiswa', 'mataKuliah'])
            ->whereIn('id_mk', $mataKuliahIds)
            ->when($request->filled('filter_mk'), fn ($query) => $query->where('id_mk', $request->query('filter_mk')))
            ->when($request->filled('filter_tgl'), fn ($query) => $query->whereDate('tanggal', $request->query('filter_tgl')))
            ->orderByDesc('tanggal')
            ->orderByDesc('id_absensi')
            ->get();

        $mahasiswaList = Mahasiswa::orderBy('nama_mahasiswa')->get();

        return view('dosen.absensi', compact('dosen', 'mataKuliahList', 'mahasiswaList', 'absensiList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $dosen = $this->currentDosen($request);

        $validated = $request->validate([
            'id_mk' => [
                'required',
                Rule::exists('mata_kuliah', 'id_mk')->where('nip_dosen', $dosen->nip),
            ],
            'nim' => ['required', 'exists:mahasiswa,nim'],
            'tanggal' => ['required', 'date'],
            'status' => ['required', 'in:Hadir,Sakit,Izin,Alfa'],
        ]);

        Absensi::create($validated);

        return redirect()->route('dosen.absensi.index')->with('success', 'Absensi berhasil dicatat!');
    }

    public function destroy(Request $request, Absensi $absensi): RedirectResponse
    {
        $dosen = $this->currentDosen($request);
        abort_unless(MataKuliah::where('nip_dosen', $dosen->nip)->where('id_mk', $absensi->id_mk)->exists(), 403);

        $absensi->delete();

        return redirect()->route('dosen.absensi.index')->with('success', 'Data absensi berhasil dihapus!');
    }
}
