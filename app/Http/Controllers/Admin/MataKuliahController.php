<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\MataKuliah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MataKuliahController extends Controller
{
    public function index(Request $request): View
    {
        $editData = null;

        if ($request->filled('edit')) {
            $editData = MataKuliah::where('id_mk', $request->query('edit'))->first();
        }

        $mataKuliahList = MataKuliah::with('dosen')->orderBy('nama_mk')->get();
        $dosenList = Dosen::orderBy('nama_dosen')->get();

        return view('admin.mata-kuliah', compact('mataKuliahList', 'dosenList', 'editData'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_mk' => ['required', 'string', 'max:20', 'unique:mata_kuliah,id_mk'],
            'nip_dosen' => ['required', 'exists:dosen,nip'],
            'nama_mk' => ['required', 'string', 'max:100'],
        ]);

        MataKuliah::create($validated);

        return redirect()
            ->route('admin.mata-kuliah.index')
            ->with('success', 'Mata kuliah berhasil ditambahkan!');
    }

    public function update(Request $request, MataKuliah $mataKuliah): RedirectResponse
    {
        $validated = $request->validate([
            'id_mk' => [
                'required',
                'string',
                'max:20',
                Rule::unique('mata_kuliah', 'id_mk')->ignore($mataKuliah->id_mk, 'id_mk'),
            ],
            'nip_dosen' => ['required', 'exists:dosen,nip'],
            'nama_mk' => ['required', 'string', 'max:100'],
        ]);

        MataKuliah::where('id_mk', $mataKuliah->id_mk)->update($validated);

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
}
