<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Dosen;
use App\Models\Mahasiswa;

class AuthController extends Controller {

    public function showLogin() {
        return view('auth.login');
    }

    public function showMahasiswaLogin(Request $request) {
        $loginRole = $request->query('role') === 'dosen' ? 'dosen' : 'mahasiswa';

        return view('auth.login-mahasiswa', compact('loginRole'));
    }

    public function showDosenLogin() {
        return view('auth.login-dosen');
    }

    public function login(Request $request) {
        $username = $request->username;
        $password = $request->password;

        $user = Admin::where('username', $username)->first();
        if ($user && Hash::check($password, $user->password)) {
            $request->session()->regenerate();
            session(['role' => 'admin', 'nama' => $user->nama, 'username' => $username]);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Username atau password salah.');
    }

    public function mahasiswaLogin(Request $request) {
        $validated = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $mahasiswa = Mahasiswa::where('nama_mahasiswa', $validated['username'])->first();

        if ($mahasiswa && Hash::check($validated['password'], $mahasiswa->password)) {
            $request->session()->regenerate();
            session([
                'role' => 'mahasiswa',
                'nama' => $mahasiswa->nama_mahasiswa,
                'username' => $mahasiswa->nama_mahasiswa,
                'nim' => $mahasiswa->nim,
            ]);

            return redirect()->route('mahasiswa.dashboard');
        }

        return back()
            ->withInput($request->only('username'))
            ->with('error', 'Nama lengkap atau NIM salah.');
    }

    public function dosenLogin(Request $request) {
        $validated = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $dosen = Dosen::where('username', $validated['username'])->first();

        if ($dosen && Hash::check($validated['password'], $dosen->password)) {
            $request->session()->regenerate();
            session([
                'role' => 'dosen',
                'nama' => $dosen->nama_dosen,
                'nip' => $dosen->nip,
                'username' => $dosen->username,
            ]);

            return redirect()->route('dosen.dashboard');
        }

        return back()
            ->withInput($request->only('username'))
            ->with('error', 'Username atau password salah.');
    }

    public function portalLogin(Request $request) {
        $role = $request->input('role') === 'dosen' ? 'dosen' : 'mahasiswa';

        return $role === 'dosen'
            ? $this->dosenLogin($request)
            : $this->mahasiswaLogin($request);
    }

    public function logout(Request $request) {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
