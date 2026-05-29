<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bimbingans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('academic_period_id');
            $table->enum('jenis_bimbingan', ['skripsi', 'tesis', 'disertasi']);
            $table->string('kategori_bimbingan')->nullable();
            $table->integer('jumlah_mahasiswa');
            $table->enum('semester', ['ganjil', 'genap']);
            $table->year('tahun_akademik');
            $table->timestamps();

            $table->index('dosen_id');
            $table->index('academic_period_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bimbingans');
    }
};
