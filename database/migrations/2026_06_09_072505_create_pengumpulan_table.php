<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pengumpulan', function (Blueprint $table) {
            $table->id('id_pengumpulan');
            $table->unsignedBigInteger('id_tugas');
            $table->string('nim', 20);
            $table->dateTime('tanggal_kumpul');
            $table->string('file_tugas', 255);
            $table->timestamps();
            $table->foreign('id_tugas')->references('id_tugas')->on('tugas')->onDelete('cascade');
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
        });
    }
    public function down(): void { Schema::dropIfExists('pengumpulan'); }
};