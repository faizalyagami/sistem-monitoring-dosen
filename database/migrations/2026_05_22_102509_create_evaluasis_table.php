<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluasis', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('academic_period_id');

            $table->string('jenis_evaluasi');
            $table->string('kategori_evaluasi');
            $table->string('nama_evaluasi');
            $table->float('nilai_evaluasi', 3, 2)->default(0.00);
            $table->enum('status', ['memenuhi', 'belum_memenuhi'])->default('memenuhi');
            $table->text('komentar')->nullable();
            $table->year('tahun');
            $table->timestamps();

            // Index untuk performa query
            $table->index('dosen_id');
            $table->index('academic_period_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluasis');
    }
};
