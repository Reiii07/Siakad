<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pengumpulan extends Model {
    protected $table = 'pengumpulan';
    protected $primaryKey = 'id_pengumpulan';
    protected $fillable = ['id_tugas', 'nim', 'tanggal_kumpul', 'file_tugas'];
}