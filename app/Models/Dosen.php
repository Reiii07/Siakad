<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model {
    protected $table = 'dosen';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['nip', 'nama_dosen', 'username', 'password'];
    protected $hidden = ['password'];
}