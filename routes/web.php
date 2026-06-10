<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\MataKuliahController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\TugasController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::middleware('role:admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/dosen', [DosenController::class, 'index'])
        ->name('admin.dosen.index');
    Route::post('/dosen', [DosenController::class, 'store'])
        ->name('admin.dosen.store');
    Route::put('/dosen/{dosen}', [DosenController::class, 'update'])
        ->name('admin.dosen.update');
    Route::delete('/dosen/{dosen}', [DosenController::class, 'destroy'])
        ->name('admin.dosen.destroy');

    Route::get('/mahasiswa/tambah', [MahasiswaController::class, 'create'])
        ->name('admin.mahasiswa.create');
    Route::post('/mahasiswa', [MahasiswaController::class, 'store'])
        ->name('admin.mahasiswa.store');
    Route::delete('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'destroy'])
        ->name('admin.mahasiswa.destroy');

    Route::get('/mata-kuliah', [MataKuliahController::class, 'index'])
        ->name('admin.mata-kuliah.index');
    Route::post('/mata-kuliah', [MataKuliahController::class, 'store'])
        ->name('admin.mata-kuliah.store');
    Route::put('/mata-kuliah/{mataKuliah}', [MataKuliahController::class, 'update'])
        ->name('admin.mata-kuliah.update');
    Route::delete('/mata-kuliah/{mataKuliah}', [MataKuliahController::class, 'destroy'])
        ->name('admin.mata-kuliah.destroy');

    Route::get('/tugas', [TugasController::class, 'index'])
        ->name('admin.tugas.index');
    Route::post('/tugas', [TugasController::class, 'store'])
        ->name('admin.tugas.store');
    Route::put('/tugas/{tugas}', [TugasController::class, 'update'])
        ->name('admin.tugas.update');
    Route::delete('/tugas/{tugas}', [TugasController::class, 'destroy'])
        ->name('admin.tugas.destroy');

    Route::get('/absensi', [AbsensiController::class, 'index'])
        ->name('admin.absensi.index');
    Route::post('/absensi', [AbsensiController::class, 'store'])
        ->name('admin.absensi.store');
    Route::delete('/absensi/{absensi}', [AbsensiController::class, 'destroy'])
        ->name('admin.absensi.destroy');

    Route::get('/pengaturan', [PengaturanController::class, 'index'])
        ->name('admin.pengaturan.index');
});
