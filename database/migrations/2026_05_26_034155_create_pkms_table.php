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
        Schema::create('table_pkms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id')->constrained('dosens')->onDelete('cascade');
            $table->foreignId('academic_period_id')->constrained('academic_periods')->onDelete('cascade');
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
            $table->year('tahun');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_pkms');
    }
};
