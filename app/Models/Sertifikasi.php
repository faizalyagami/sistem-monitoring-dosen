<?php
// app/Models/Sertifikasi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikasi extends Model
{
    use HasFactory;

    protected $table = 'sertifikasis';

    protected $fillable = [
        'dosen_id',
        'academic_period_id',
        'jenis_sertifikasi',
        'lembaga_sertifikasi',
        'nomor_sertifikasi',
        'tanggal_sertifikasi',
        'valid_until',
        'file_sertifikat',
    ];

    protected $casts = [
        'tanggal_sertifikasi' => 'date',
        'valid_until' => 'date',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function academicPeriod()
    {
        return $this->belongsTo(AcademicPeriod::class, 'academic_period_id');
    }

    public function getStatusAttribute()
    {
        if (!$this->valid_until) {
            return '<span class="badge bg-success">Aktif</span>';
        }
        return now() <= $this->valid_until
            ? '<span class="badge bg-success">Aktif</span>'
            : '<span class="badge bg-danger">Kadaluarsa</span>';
    }
}
