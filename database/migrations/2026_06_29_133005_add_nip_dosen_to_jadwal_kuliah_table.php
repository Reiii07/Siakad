<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('jadwal_kuliah', function (Blueprint $table) {
            $table->string('nip_dosen', 20)->after('id_mk');
            $table->foreign('nip_dosen')->references('nip')->on('dosen')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jadwal_kuliah', function (Blueprint $table) {
            $table->dropForeign(['nip_dosen']);
            $table->dropColumn('nip_dosen');
        });
    }
};
