<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model {
    protected $table = 'absensi';
    protected $primaryKey = 'id_absensi';
    protected $fillable = ['id_mk', 'nim', 'tanggal', 'status'];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function mataKuliah(): BelongsTo
    {
        return $this->belongsTo(MataKuliah::class, 'id_mk', 'id_mk');
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
