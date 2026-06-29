<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    public function create(): View
    {
        return view('admin.tambah-mhs');
    }

    public function edit(Mahasiswa $mahasiswa): View
    {
        return view('admin.tambah-mhs', compact('mahasiswa'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nim' => ['required', 'string', 'max:20', 'unique:mahasiswa,nim'],
            'nama_mahasiswa' => ['required', 'string', 'max:100', 'unique:mahasiswa,username'],
        ]);

        $validated['username'] = $validated['nama_mahasiswa'];
        $validated['password'] = Hash::make($validated['nim']);

        Mahasiswa::create($validated);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Mahasiswa berhasil ditambahkan!');
    }

    public function destroy(Mahasiswa $mahasiswa): RedirectResponse
    {
        $mahasiswa->delete();

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Mahasiswa berhasil dihapus!');
    }

    public function update(Request $request, Mahasiswa $mahasiswa): RedirectResponse
    {
        $validated = $request->validate([
            'nama_mahasiswa' => [
                'required',
                'string',
                'max:100',
                Rule::unique('mahasiswa', 'username')->ignore($mahasiswa->nim, 'nim'),
            ],
        ]);

        $mahasiswa->update([
            'nama_mahasiswa' => $validated['nama_mahasiswa'],
            'username' => $validated['nama_mahasiswa'],
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Data mahasiswa berhasil diperbarui!');
    }
}
