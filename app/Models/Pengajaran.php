<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajaran extends Model
{
    use HasFactory;

    protected $table = 'pengajaran';

    protected $fillable = [
        'kode_mk',
        'nama_mk',
        'bidang_keilmuan',
        'kelas',
        'sks',
        'jumlah_mahasiswa',
        'semester',
        'tahun_akademik',
        'no_sk',
        'tanggal_sk',
        'dosen_id',
        'academic_period_id',
    ];

    /**
     * Relasi ke Dosen
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id');
    }

    /**
     * Relasi ke Academic Period
     */
    public function academicPeriod()
    {
        return $this->belongsTo(AcademicPeriod::class, 'academic_period_id', 'id');
    }

    /**
     * Accessor total jam
     */
    public function getTotalJamAttribute()
    {
        return $this->sks * 16;
    }

    public function getTanggalSkFormattedAttribute()
    {
        return $this->tanggal_sk ? $this->tanggal_sk->format('d/m/Y') : '-';
    }
}
