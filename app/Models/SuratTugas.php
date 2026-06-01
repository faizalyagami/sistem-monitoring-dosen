<?php
// app/Models/SuratTugas.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTugas extends Model
{
    use HasFactory;

    protected $table = 'surat_tugas';

    protected $fillable = [
        'dosen_id',
        'academic_period_id',
        'nama_surat_tugas',
        'no_surat_tugas',
        'perihal',
        'tanggal_surat_tugas',
        'file_surat',
    ];

    protected $casts = [
        'tanggal_surat_tugas' => 'date',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function academicPeriod()
    {
        return $this->belongsTo(AcademicPeriod::class, 'academic_period_id');
    }
}
