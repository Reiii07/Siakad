<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dosen extends Model {
    protected $table = 'dosen';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['nip', 'nama_dosen', 'username', 'password'];
    protected $hidden = ['password'];

    public function mataKuliah(): HasMany
    {
        return $this->hasMany(MataKuliah::class, 'nip_dosen', 'nip');
    }

    public function jadwalKuliah(): HasMany
    {
        return $this->hasMany(JadwalKuliah::class, 'nip_dosen', 'nip');
    }
}
