<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id('id_absensi');
            $table->string('id_mk', 20);
            $table->string('nim', 20);
            $table->date('tanggal');
            $table->string('status', 20);
            $table->timestamps();
            $table->foreign('id_mk')->references('id_mk')->on('mata_kuliah')->onDelete('cascade');
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
        });
    }
    public function down(): void { Schema::dropIfExists('absensi'); }
};