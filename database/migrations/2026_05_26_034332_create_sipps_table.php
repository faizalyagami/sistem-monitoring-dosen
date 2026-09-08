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
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->timestamps();

            $table->index('dosen_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('table_sipps');
    }
};
