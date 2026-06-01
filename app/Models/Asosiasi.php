<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asosiasi extends Model
{
    use HasFactory;

    protected $table = 'table_asosiasis';

    protected $fillable = [
        'dosen_id',
        'academic_period_id',
        'nama_asosiasi',
        'peran',
        'masa_aktif',
        'tahun',
    ];

    protected $casts = [
        'masa_aktif' => 'date',
        'tahun' => 'integer',
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
