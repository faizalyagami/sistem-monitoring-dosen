<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelatihan extends Model
{
    use HasFactory;

    protected $table = 'pelatihans';

    protected $fillable = [
        'dosen_id',
        'academic_period_id',
        'nama_pelatihan',
        'penyelenggara',
        'tanggal_pelatihan',
        'lokasi',
        'tahun',
        'file_sertifikat',
        'durasi',
    ];

    protected $casts = [
        'tanggal_pelatihan' => 'date',
        'tahun' => 'integer',
        'durasi' => 'integer',
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
