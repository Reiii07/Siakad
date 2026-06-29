<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Mahasiswa\JadwalController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\MataKuliahController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Mahasiswa\AbsensiController as MahasiswaAbsensiController;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\TugasController as MahasiswaTugasController;
use App\Http\Controllers\Dosen\AbsensiController as DosenAbsensiController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Dosen\JadwalController as DosenJadwalController;
use App\Http\Controllers\Dosen\TugasController as DosenTugasController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth
Route::get('/login', [AuthController::class, 'showMahasiswaLogin'])->name('login');
Route::post('/login', [AuthController::class, 'portalLogin'])->name('login.post');
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.post');
Route::get('/mahasiswa/login', fn () => redirect()->route('login'))->name('mahasiswa.login');
Route::post('/mahasiswa/login', [AuthController::class, 'portalLogin'])->name('mahasiswa.login.post');
Route::get('/dosen/login', fn () => redirect()->route('login', ['role' => 'dosen']))->name('dosen.login');
Route::post('/dosen/login', [AuthController::class, 'portalLogin'])->name('dosen.login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::middleware('role:admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('admin.notifications.read-all');

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

    Route::get('/pengaturan', [PengaturanController::class, 'index'])
        ->name('admin.pengaturan.index');
});

Route::middleware('role:mahasiswa')->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/profil', [MahasiswaDashboardController::class, 'profil'])
        ->name('profil.index');
    Route::post('/profil', [MahasiswaDashboardController::class, 'profilUpdate'])
        ->name('profil.update');

    Route::get('/jadwal', [App\Http\Controllers\Mahasiswa\JadwalController::class, 'index'])
        ->name('jadwal.index');
    Route::get('/tugas', [MahasiswaTugasController::class, 'index'])
        ->name('tugas.index');
    Route::post('/tugas/{tugas}/kumpul', [MahasiswaTugasController::class, 'store'])
        ->name('tugas.store');
    Route::get('/absensi', [MahasiswaAbsensiController::class, 'index'])
        ->name('absensi.index');
});

Route::middleware('role:dosen')->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/dashboard', [DosenDashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/jadwal', [DosenJadwalController::class, 'index'])
        ->name('jadwal.index');
    Route::get('/tugas', [DosenTugasController::class, 'index'])
        ->name('tugas.index');
    Route::post('/tugas', [DosenTugasController::class, 'store'])
        ->name('tugas.store');
    Route::put('/tugas/{tugas}', [DosenTugasController::class, 'update'])
        ->name('tugas.update');
    Route::delete('/tugas/{tugas}', [DosenTugasController::class, 'destroy'])
        ->name('tugas.destroy');
    Route::get('/absensi', [DosenAbsensiController::class, 'index'])
        ->name('absensi.index');
    Route::post('/absensi', [DosenAbsensiController::class, 'store'])
        ->name('absensi.store');
    Route::delete('/absensi/{absensi}', [DosenAbsensiController::class, 'destroy'])
        ->name('absensi.destroy');
});
