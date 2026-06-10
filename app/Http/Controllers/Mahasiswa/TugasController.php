<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Pengumpulan;
use App\Models\Tugas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TugasController extends Controller
{
    public function index(Request $request): View
    {
        $nim = $request->session()->get('nim');
        $pengumpulan = Pengumpulan::where('nim', $nim)->get()->keyBy('id_tugas');

        $tugasList = Tugas::with('mataKuliah')
            ->orderBy('deadline')
            ->get()
            ->map(function (Tugas $tugas) use ($pengumpulan) {
                $tugas->pengumpulan_mahasiswa = $pengumpulan->get($tugas->id_tugas);

                return $tugas;
            });

        return view('mahasiswa.tugas', compact('tugasList'));
    }

    public function store(Request $request, Tugas $tugas): RedirectResponse
    {
        $nim = $request->session()->get('nim');

        $validated = $request->validate([
            'file_tugas' => ['required', 'file', 'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar,jpg,jpeg,png', 'max:5120'],
        ]);

        $existing = Pengumpulan::where('nim', $nim)
            ->where('id_tugas', $tugas->id_tugas)
            ->first();

        if ($existing && $existing->file_tugas && Storage::disk('public')->exists($existing->file_tugas)) {
            Storage::disk('public')->delete($existing->file_tugas);
        }

        $path = $validated['file_tugas']->store("pengumpulan/{$nim}", 'public');

        Pengumpulan::updateOrCreate(
            [
                'nim' => $nim,
                'id_tugas' => $tugas->id_tugas,
            ],
            [
                'tanggal_kumpul' => now(),
                'file_tugas' => $path,
            ]
        );

        return redirect()
            ->route('mahasiswa.tugas.index')
            ->with('success', 'Tugas berhasil dikumpulkan.');
    }
}
