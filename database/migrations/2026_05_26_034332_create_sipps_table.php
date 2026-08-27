<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('table_sipps', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('dosen_id');

            $table->string('no_registrasi');
            $table->string('bidang_keilmuan');
            $table->year('tahun_terbit');
            $table->string('penerbit')->nullable();
            $table->string('file_sipp')->nullable();
            $table->enum('status', ['aktif', 'kadaluarsa', 'dicabut'])->default('aktif');
            $table->date('tanggal_terbit');
            $table->date('tanggal_kadaluarsa')->nullable();
            $table->text('keterangan');
            $table->timestamps();

            $table->index('dosen_id');
            $table->index('no_registrasi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('table_sipps');
    }
};
