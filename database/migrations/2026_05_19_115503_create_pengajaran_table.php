<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajaran', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mk')->unique();
            $table->string('nama_mk');
            $table->string('bidang_keilmuan');
            $table->string('kelas');
            $table->integer('sks');
            $table->integer('jumlah_mahasiswa');
            $table->enum('semester', ['ganjil', 'genap']);
            $table->year('tahun_akademik');

            // Tanpa foreign key
            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('academic_period_id');

            $table->timestamps();

            // Index untuk join
            $table->index('dosen_id');
            $table->index('academic_period_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajaran');
    }
};
