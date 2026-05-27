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
        Schema::create('table_risets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dosen_id')->constrained('dosens')->onDelete('cascade');
            $table->foreignId('academic_period_id')->constrained('academic_periods')->onDelete('cascade');
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_risets');
    }
};
