<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('jadwal_kuliah', 'nip_dosen')) {
            Schema::table('jadwal_kuliah', function (Blueprint $table) {
                $table->string('nip_dosen', 20)->nullable()->after('id_mk');
                $table->foreign('nip_dosen')->references('nip')->on('dosen')->onDelete('cascade');
            });
        }

        DB::table('jadwal_kuliah')
            ->select('jadwal_kuliah.id_jadwal', 'mata_kuliah.nip_dosen')
            ->join('mata_kuliah', 'jadwal_kuliah.id_mk', '=', 'mata_kuliah.id_mk')
            ->orderBy('jadwal_kuliah.id_jadwal')
            ->each(function ($jadwal) {
                DB::table('jadwal_kuliah')
                    ->where('id_jadwal', $jadwal->id_jadwal)
                    ->update(['nip_dosen' => $jadwal->nip_dosen]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('jadwal_kuliah', 'nip_dosen')) {
            try {
                Schema::table('jadwal_kuliah', function (Blueprint $table) {
                    $table->dropForeign(['nip_dosen']);
                });
            } catch (\Throwable) {
            }

            Schema::table('jadwal_kuliah', function (Blueprint $table) {
                $table->dropColumn('nip_dosen');
            });
        }
    }
};
