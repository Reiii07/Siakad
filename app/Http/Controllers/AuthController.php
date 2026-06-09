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

    public function login(Request $request) {
        $username = $request->username;
        $password = $request->password;

        // Cek admin
        $user = Admin::where('username', $username)->first();
        if ($user && Hash::check($password, $user->password)) {
            session(['role' => 'admin', 'nama' => $user->nama, 'username' => $username]);
            return redirect()->route('admin.dashboard');
        }

        // Cek dosen
        $user = Dosen::where('username', $username)->first();
        if ($user && Hash::check($password, $user->password)) {
            session(['role' => 'dosen', 'nama' => $user->nama_dosen, 'username' => $username]);
            return redirect()->route('dosen.dashboard');
        }

        // Cek mahasiswa
        $user = Mahasiswa::where('username', $username)->first();
        if ($user && Hash::check($password, $user->password)) {
            session(['role' => 'mahasiswa', 'nama' => $user->nama_mahasiswa, 'username' => $username]);
            return redirect()->route('mahasiswa.dashboard');
        }

        return back()->with('error', 'Username atau password salah.');
    }

    public function logout() {
        session()->flush();
        return redirect()->route('login');
    }
}