<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jadwal_kuliah', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->string('id_mk', 20); // Menghubungkan ke id_mk di tabel mata_kuliah
            $table->string('hari', 20);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('ruangan', 50);
            $table->timestamps();

            // Aturan: Jika mata kuliah dihapus, jadwalnya otomatis terhapus
            $table->foreign('id_mk')->references('id_mk')->on('mata_kuliah')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_kuliah');
    }
};