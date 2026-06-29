<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\MataKuliah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MataKuliahController extends Controller
{
    public function index(Request $request): View
    {
        $editData = null;

        if ($request->filled('edit')) {
            $editData = MataKuliah::where('id_mk', $request->query('edit'))->first();
        }

        $mataKuliahList = MataKuliah::with('dosen')
            ->orderBy('nip_dosen')
            ->orderBy('nama_mk')
            ->get();
        $dosenList = Dosen::with(['mataKuliah' => fn ($query) => $query->orderBy('nama_mk')])
            ->withCount('mataKuliah')
            ->orderBy('nama_dosen')
            ->get();
        $nextMataKuliahId = $this->generateNextMataKuliahId();

        return view('admin.mata-kuliah', compact('mataKuliahList', 'dosenList', 'editData', 'nextMataKuliahId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nip_dosen' => ['required', 'exists:dosen,nip'],
            'nama_mk' => ['required', 'string', 'max:100'],
        ]);

        $validated['id_mk'] = $this->generateNextMataKuliahId();

        MataKuliah::create($validated);

        return redirect()
            ->route('admin.mata-kuliah.index')
            ->with('success', 'Mata kuliah berhasil ditambahkan!');
    }

    public function update(Request $request, MataKuliah $mataKuliah): RedirectResponse
    {
        $validated = $request->validate([
            'nip_dosen' => ['required', 'exists:dosen,nip'],
            'nama_mk' => ['required', 'string', 'max:100'],
        ]);

        $mataKuliah->update($validated);
        $mataKuliah->jadwalKuliah()->update(['nip_dosen' => $validated['nip_dosen']]);

        return redirect()
            ->route('admin.mata-kuliah.index')
            ->with('success', 'Mata kuliah berhasil diperbarui!');
    }

    public function destroy(MataKuliah $mataKuliah): RedirectResponse
    {
        $mataKuliah->delete();

        return redirect()
            ->route('admin.mata-kuliah.index')
            ->with('success', 'Mata kuliah berhasil dihapus!');
    }

    private function generateNextMataKuliahId(): string
    {
        $lastNumber = 0;

        foreach (MataKuliah::pluck('id_mk') as $code) {
            if (preg_match('/^MK(\d+)$/', (string) $code, $matches)) {
                $lastNumber = max($lastNumber, (int) $matches[1]);
            }
        }

        do {
            $lastNumber++;
            $nextCode = 'MK' . str_pad((string) $lastNumber, 3, '0', STR_PAD_LEFT);
        } while (MataKuliah::where('id_mk', $nextCode)->exists());

        return $nextCode;
    }
}
