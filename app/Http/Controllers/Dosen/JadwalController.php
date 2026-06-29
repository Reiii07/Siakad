<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Dosen\Concerns\ResolvesDosen;
use App\Models\JadwalKuliah;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalController extends Controller
{
    use ResolvesDosen;

    public function index(Request $request): View
    {
        $dosen = $this->currentDosen($request);
        $mataKuliahList = MataKuliah::where('nip_dosen', $dosen->nip)
            ->orderBy('nama_mk')
            ->get();

        $jadwalKuliah = JadwalKuliah::with('mataKuliah')
            ->whereIn('id_mk', $mataKuliahList->pluck('id_mk'))
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        return view('dosen.jadwal', compact('dosen', 'mataKuliahList', 'jadwalKuliah'));
    }
}
