<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengumpulan extends Model {
    protected $table = 'pengumpulan';
    protected $primaryKey = 'id_pengumpulan';
    public $timestamps = false;
    protected $fillable = ['id_tugas', 'nim', 'tanggal_kumpul', 'file_tugas'];

    protected function casts(): array
    {
        return [
            'tanggal_kumpul' => 'datetime',
        ];
    }

    public function tugas(): BelongsTo
    {
        return $this->belongsTo(Tugas::class, 'id_tugas', 'id_tugas');
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
