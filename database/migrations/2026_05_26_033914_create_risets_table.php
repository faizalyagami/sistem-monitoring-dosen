<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('table_risets', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('academic_period_id');

            $table->string('judul_riset');
            $table->string('bidang_riset');
            $table->string('jenis_riset');
            $table->string('sumber_dana');
            $table->integer('jumlah_dana');
            $table->enum('status', ['aktif', 'selesai'])->default('aktif');
            $table->string('publikasi_link')->nullable();
            $table->string('kolaborator')->nullable();
            $table->string('file_laporan')->nullable();
            $table->year('tahun');
            $table->timestamps();

            $table->index('dosen_id');
            $table->index('academic_period_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('table_risets');
    }
};
