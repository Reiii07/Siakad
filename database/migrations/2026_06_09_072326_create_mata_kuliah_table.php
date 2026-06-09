<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mata_kuliah', function (Blueprint $table) {
            $table->string('id_mk', 20)->primary();
            $table->string('nip_dosen', 20);
            $table->string('nama_mk', 100);
            $table->timestamps();
            $table->foreign('nip_dosen')->references('nip')->on('dosen')->onDelete('cascade');
        });
    }
    public function down(): void { Schema::dropIfExists('mata_kuliah'); }
};