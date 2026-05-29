<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('table_pkms', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('academic_period_id');

            $table->string('judul_pkm');
            $table->string('bidang_pkm');
            $table->string('jenis_pkm');
            $table->string('sumber_dana');
            $table->integer('jumlah_dana');
            $table->string('lokasi_kegiatan');
            $table->enum('status', ['aktif', 'selesai'])->default('aktif');
            $table->year('tahun');
            $table->string('publikasi_link')->nullable();
            $table->string('file_laporan')->nullable();
            $table->timestamps();

            $table->index('dosen_id');
            $table->index('academic_period_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('table_pkms');
    }
};
