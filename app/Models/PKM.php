<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PKM extends Model
{
    use HasFactory;

    protected $table = 'table_pkms';

    protected $fillable = [
        'dosen_id',
        'academic_period_id',
        'judul_pkm',
        'bidang_pkm',
        'jenis_pkm',
        'sumber_dana',
        'jumlah_dana',
        'lokasi_kegiatan',
        'status',
        'tahun',
        'publikasi_link',
        'file_laporan',
    ];

    protected $casts = [
        'jumlah_dana' => 'integer',
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

    public function getFormattedDanaAttribute()
    {
        return 'Rp ' . number_format($this->jumlah_dana, 0, ',', '.');
    }
}
