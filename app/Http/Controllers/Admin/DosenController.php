<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DosenController extends Controller
{
    public function index(Request $request): View
    {
        $editData = null;

        if ($request->filled('edit')) {
            $editData = Dosen::where('nip', $request->query('edit'))->first();
        }

        $dosenList = Dosen::orderBy('nama_dosen')->get();

        return view('admin.dosen', compact('dosenList', 'editData'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nip' => ['required', 'string', 'max:20', 'unique:dosen,nip'],
            'nama_dosen' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:dosen,username'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Dosen::create($validated);

        return redirect()
            ->route('admin.dosen.index')
            ->with('success', 'Dosen berhasil ditambahkan!');
    }

    public function update(Request $request, Dosen $dosen): RedirectResponse
    {
        $validated = $request->validate([
            'nip' => [
                'required',
                'string',
                'max:20',
                Rule::unique('dosen', 'nip')->ignore($dosen->nip, 'nip'),
            ],
            'nama_dosen' => ['required', 'string', 'max:100'],
            'username' => [
                'required',
                'string',
                'max:50',
                Rule::unique('dosen', 'username')->ignore($dosen->nip, 'nip'),
            ],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        Dosen::where('nip', $dosen->nip)->update($validated);

        return redirect()
            ->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil diperbarui!');
    }

    public function destroy(Dosen $dosen): RedirectResponse
    {
        $dosen->delete();

        return redirect()
            ->route('admin.dosen.index')
            ->with('success', 'Dosen berhasil dihapus!');
    }
}
