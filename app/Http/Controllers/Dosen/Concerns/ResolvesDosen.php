<?php

namespace App\Http\Controllers\Dosen\Concerns;

use App\Models\Dosen;
use Illuminate\Http\Request;

trait ResolvesDosen
{
    protected function currentDosen(Request $request): Dosen
    {
        $nip = $request->session()->get('nip');

        if ($nip) {
            $dosen = Dosen::where('nip', $nip)->first();
        } else {
            $dosen = Dosen::where('username', $request->session()->get('username'))->first();
        }

        abort_unless($dosen, 403, 'Data dosen tidak ditemukan.');

        return $dosen;
    }
}
