<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelatihans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('academic_period_id');

            $table->string('nama_pelatihan');
            $table->string('penyelenggara');
            $table->date('tanggal_pelatihan');
            $table->string('lokasi');
            $table->year('tahun');
            $table->string('file_sertifikat')->nullable();
            $table->integer('durasi')->nullable();
            $table->timestamps();

            $table->index('dosen_id');
            $table->index('academic_period_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pelatihans');
    }
};
