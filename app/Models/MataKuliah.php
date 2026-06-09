<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model {
    protected $table = 'mata_kuliah';
    protected $primaryKey = 'id_mk';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id_mk', 'nip_dosen', 'nama_mk'];
}