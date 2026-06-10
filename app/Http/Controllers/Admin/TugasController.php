<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use App\Models\Tugas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TugasController extends Controller
{
    public function index(Request $request): View
    {
        $editData = null;

        if ($request->filled('edit')) {
            $editData = Tugas::where('id_tugas', $request->query('edit'))->first();
        }

        $tugasList = Tugas::with('mataKuliah')->orderByDesc('deadline')->get();
        $mataKuliahList = MataKuliah::orderBy('nama_mk')->get();

        return view('admin.tugas', compact('tugasList', 'mataKuliahList', 'editData'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_mk' => ['required', 'exists:mata_kuliah,id_mk'],
            'judul' => ['required', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string'],
            'deadline' => ['required', 'date'],
        ]);

        $validated['deskripsi'] ??= '';

        Tugas::create($validated);

        return redirect()
            ->route('admin.tugas.index')
            ->with('success', 'Tugas berhasil ditambahkan!');
    }

    public function update(Request $request, Tugas $tugas): RedirectResponse
    {
        $validated = $request->validate([
            'id_mk' => ['required', 'exists:mata_kuliah,id_mk'],
            'judul' => ['required', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string'],
            'deadline' => ['required', 'date'],
        ]);

        $validated['deskripsi'] ??= '';

        $tugas->update($validated);

        return redirect()
            ->route('admin.tugas.index')
            ->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroy(Tugas $tugas): RedirectResponse
    {
        $tugas->delete();

        return redirect()
            ->route('admin.tugas.index')
            ->with('success', 'Tugas berhasil dihapus!');
    }
}
