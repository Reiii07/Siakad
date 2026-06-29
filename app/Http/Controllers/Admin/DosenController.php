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
        $nextDosenId = $this->generateNextDosenId();

        return view('admin.dosen', compact('dosenList', 'editData', 'nextDosenId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_dosen' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', 'unique:dosen,username'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $validated['nip'] = $this->generateNextDosenId();
        $validated['password'] = Hash::make($validated['password']);

        Dosen::create($validated);

        return redirect()
            ->route('admin.dosen.index')
            ->with('success', 'Dosen berhasil ditambahkan!');
    }

    public function update(Request $request, Dosen $dosen): RedirectResponse
    {
        $validated = $request->validate([
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

        $dosen->update($validated);

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

    private function generateNextDosenId(): string
    {
        return $this->generateNextCode(Dosen::pluck('nip'), 'DSN');
    }

    private function generateNextCode(iterable $codes, string $prefix): string
    {
        $lastNumber = 0;

        foreach ($codes as $code) {
            if (preg_match('/^' . preg_quote($prefix, '/') . '(\d+)$/', (string) $code, $matches)) {
                $lastNumber = max($lastNumber, (int) $matches[1]);
            }
        }

        do {
            $lastNumber++;
            $nextCode = $prefix . str_pad((string) $lastNumber, 3, '0', STR_PAD_LEFT);
        } while (Dosen::where('nip', $nextCode)->exists());

        return $nextCode;
    }
}
