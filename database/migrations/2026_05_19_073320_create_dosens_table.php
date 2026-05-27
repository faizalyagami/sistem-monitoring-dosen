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
        Schema::create('dosens', function (Blueprint $table) {
            $table->id();
            $table->string('nidn')->unique();
            $table->string('nik')->unique();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('photo')->nullable();
            $table->enum('status', ['tetap', 'kontrak', 'luar_biasa', 'pensiun'])->default('tetap');
            $table->string('pendidikan_terakhir');
            $table->string('jabatan_fungsional');
            $table->string('inpassing');
            $table->string('kepangkatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};
