<?php
// database/migrations/2024_06_01_000001_add_sk_columns_to_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Tabel Pengajaran
        Schema::table('pengajaran', function (Blueprint $table) {
            $table->string('no_sk')->nullable()->after('tahun_akademik');
            $table->date('tanggal_sk')->nullable()->after('no_sk');
        });

        // 2. Tabel Riset/Penelitian
        Schema::table('table_risets', function (Blueprint $table) {
            $table->string('no_sk')->nullable()->after('tahun');
            $table->date('tanggal_sk')->nullable()->after('no_sk');
        });

        // 3. Tabel PKM
        Schema::table('table_pkms', function (Blueprint $table) {
            $table->string('no_sk')->nullable()->after('tahun');
            $table->date('tanggal_sk')->nullable()->after('no_sk');
        });

        // 4. Tabel Bimbingan
        Schema::table('bimbingans', function (Blueprint $table) {
            $table->string('no_sk_pembimbing')->nullable()->after('tahun_akademik');
            $table->date('tanggal_sk_pembimbing')->nullable()->after('no_sk_pembimbing');
            $table->string('no_sk_penguji')->nullable()->after('tanggal_sk_pembimbing');
            $table->date('tanggal_sk_penguji')->nullable()->after('no_sk_penguji');
        });
    }

    public function down()
    {
        Schema::table('pengajaran', function (Blueprint $table) {
            $table->dropColumn(['no_sk', 'tanggal_sk']);
        });

        Schema::table('table_risets', function (Blueprint $table) {
            $table->dropColumn(['no_sk', 'tanggal_sk']);
        });

        Schema::table('table_pkms', function (Blueprint $table) {
            $table->dropColumn(['no_sk', 'tanggal_sk']);
        });

        Schema::table('bimbingans', function (Blueprint $table) {
            $table->dropColumn(['no_sk_pembimbing', 'tanggal_sk_pembimbing', 'no_sk_penguji', 'tanggal_sk_penguji']);
        });
    }
};
