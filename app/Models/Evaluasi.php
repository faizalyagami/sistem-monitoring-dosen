<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluasi extends Model
{
    use HasFactory;

    protected $table = 'evaluasis';

    protected $fillable = [
        'dosen_id',
        'academic_period_id',
        'jenis_evaluasi',
        'kategori_evaluasi',
        'nama_evaluasi',
        'nilai_evaluasi',
        'status',
        'komentar',
        'tahun',
    ];

    protected $casts = [
        'nilai_evaluasi' => 'float',
        'tahun' => 'integer',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function academicPeriod()
    {
        return $this->belongsTo(AcademicPeriod::class, 'academic_period_id');
    }
}
