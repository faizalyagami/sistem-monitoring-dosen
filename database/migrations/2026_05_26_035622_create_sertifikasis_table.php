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
        Schema::create('sertifikasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('academic_period_id');
            $table->string('jenis_sertifikasi');
            $table->string('lembaga_sertifikasi');
            $table->string('nomor_sertifikasi')->unique();
            $table->date('tanggal_sertifikasi');
            $table->date('valid_until');
            $table->string('file_sertifikat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_sertifikasi');
    }
};
