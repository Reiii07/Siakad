<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\JadwalKuliah;
use App\Models\MataKuliah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JadwalKuliahController extends Controller
{
    public function index(Request $request): View
    {
        $editData = null;

        if ($request->filled('edit')) {
            $editData = JadwalKuliah::where('id_jadwal', $request->query('edit'))->first();
        }

        $jadwalList = JadwalKuliah::with(['mataKuliah.dosen', 'dosen'])
            ->orderByRaw("CASE hari WHEN 'Senin' THEN 1 WHEN 'Selasa' THEN 2 WHEN 'Rabu' THEN 3 WHEN 'Kamis' THEN 4 WHEN 'Jumat' THEN 5 WHEN 'Sabtu' THEN 6 WHEN 'Minggu' THEN 7 ELSE 8 END")
            ->orderBy('jam_mulai')
            ->get();
        $dosenList = Dosen::orderBy('nama_dosen')->get();
        $mataKuliahList = MataKuliah::with('dosen')
            ->orderBy('nama_mk')
            ->get();

        return view('admin.jadwal-kuliah', compact('jadwalList', 'dosenList', 'mataKuliahList', 'editData'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedData($request);

        JadwalKuliah::create($validated);

        return redirect()
            ->route('admin.jadwal-kuliah.index')
            ->with('success', 'Jadwal kuliah berhasil ditambahkan!');
    }

    public function update(Request $request, JadwalKuliah $jadwalKuliah): RedirectResponse
    {
        $validated = $this->validatedData($request);

        $jadwalKuliah->update($validated);

        return redirect()
            ->route('admin.jadwal-kuliah.index')
            ->with('success', 'Jadwal kuliah berhasil diperbarui!');
    }

    public function destroy(JadwalKuliah $jadwalKuliah): RedirectResponse
    {
        $jadwalKuliah->delete();

        return redirect()
            ->route('admin.jadwal-kuliah.index')
            ->with('success', 'Jadwal kuliah berhasil dihapus!');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'nip_dosen' => ['required', 'exists:dosen,nip'],
            'id_mk' => [
                'required',
                Rule::exists('mata_kuliah', 'id_mk')->where('nip_dosen', $request->input('nip_dosen')),
            ],
            'hari' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'])],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'ruangan' => ['required', 'string', 'max:50'],
        ], [
            'id_mk.exists' => 'Mata kuliah harus sesuai dengan dosen yang dipilih.',
            'jam_selesai.after' => 'Jam selesai harus lebih besar dari jam mulai.',
        ]);
    }
}
