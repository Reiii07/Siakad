<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tugas extends Model {
    protected $table = 'tugas';
    protected $primaryKey = 'id_tugas';
    protected $fillable = ['id_mk', 'judul', 'deskripsi', 'deadline'];

    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
        ];
    }

    public function mataKuliah(): BelongsTo
    {
        return $this->belongsTo(MataKuliah::class, 'id_mk', 'id_mk');
    }
}
