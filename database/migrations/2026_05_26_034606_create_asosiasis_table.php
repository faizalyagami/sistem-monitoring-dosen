<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('table_asosiasis', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('dosen_id');
            $table->unsignedBigInteger('academic_period_id');

            $table->string('nama_asosiasi');
            $table->string('peran');
            $table->date('masa_aktif');
            $table->year('tahun');
            $table->timestamps();

            $table->index('dosen_id');
            $table->index('academic_period_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('table_asosiasis');
    }
};
