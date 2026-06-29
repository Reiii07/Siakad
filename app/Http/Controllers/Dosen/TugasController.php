<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dosen\Concerns\ResolvesDosen;
use App\Models\MataKuliah;
use App\Models\Tugas;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TugasController extends Controller
{
    use ResolvesDosen;

    public function index(Request $request): View
    {
        $dosen = $this->currentDosen($request);
        $mataKuliahList = MataKuliah::where('nip_dosen', $dosen->nip)->orderBy('nama_mk')->get();
        $mataKuliahIds = $mataKuliahList->pluck('id_mk');
        $editData = null;

        if ($request->filled('edit')) {
            $editData = Tugas::whereIn('id_mk', $mataKuliahIds)
                ->where('id_tugas', $request->query('edit'))
                ->first();
        }

        $tugasList = Tugas::with('mataKuliah')
            ->withCount('pengumpulan')
            ->whereIn('id_mk', $mataKuliahIds)
            ->orderByDesc('deadline')
            ->get();

        return view('dosen.tugas', compact('dosen', 'mataKuliahList', 'tugasList', 'editData'));
    }

    public function store(Request $request): RedirectResponse
    {
        $dosen = $this->currentDosen($request);
        $validated = $this->validatedData($request, $dosen->nip);
        $validated['deskripsi'] ??= '';

        Tugas::create($validated);

        return redirect()->route('dosen.tugas.index')->with('success', 'Tugas berhasil ditambahkan!');
    }

    public function update(Request $request, Tugas $tugas): RedirectResponse
    {
        $dosen = $this->currentDosen($request);
        abort_unless($this->ownsTugas($tugas, $dosen->nip), 403);

        $validated = $this->validatedData($request, $dosen->nip);
        $validated['deskripsi'] ??= '';

        $tugas->update($validated);

        return redirect()->route('dosen.tugas.index')->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroy(Request $request, Tugas $tugas): RedirectResponse
    {
        $dosen = $this->currentDosen($request);
        abort_unless($this->ownsTugas($tugas, $dosen->nip), 403);

        $tugas->delete();

        return redirect()->route('dosen.tugas.index')->with('success', 'Tugas berhasil dihapus!');
    }

    private function validatedData(Request $request, string $nip): array
    {
        return $request->validate([
            'id_mk' => [
                'required',
                Rule::exists('mata_kuliah', 'id_mk')->where('nip_dosen', $nip),
            ],
            'judul' => ['required', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string'],
            'deadline' => ['required', 'date'],
        ]);
    }

    private function ownsTugas(Tugas $tugas, string $nip): bool
    {
        return MataKuliah::where('nip_dosen', $nip)->where('id_mk', $tugas->id_mk)->exists();
    }
}
