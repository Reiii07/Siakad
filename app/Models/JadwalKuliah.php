<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalKuliah extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kuliah';
    protected $primaryKey = 'id_jadwal';
    protected $fillable = ['id_mk', 'nip_dosen', 'hari', 'jam_mulai', 'jam_selesai', 'ruangan'];

    // Relasi: Menghubungkan jadwal ke data mata kuliah
    public function mataKuliah(): BelongsTo
    {
        return $this->belongsTo(MataKuliah::class, 'id_mk', 'id_mk');
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'nip_dosen', 'nip');
    }
}
