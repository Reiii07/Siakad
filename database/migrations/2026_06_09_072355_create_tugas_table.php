<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tugas', function (Blueprint $table) {
            $table->id('id_tugas');
            $table->string('id_mk', 20);
            $table->string('judul', 150);
            $table->text('deskripsi');
            $table->dateTime('deadline');
            $table->timestamps();
            $table->foreign('id_mk')->references('id_mk')->on('mata_kuliah')->onDelete('cascade');
        });
    }
    public function down(): void { Schema::dropIfExists('tugas'); }
};