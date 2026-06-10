<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class MahasiswaController extends Controller
{
    public function create(): View
    {
        return view('admin.tambah-mhs');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nim' => ['required', 'string', 'max:20', 'unique:mahasiswa,nim'],
            'nama_mahasiswa' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:mahasiswa,username'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

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
}
