<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    use HasFactory;

    protected $fillable = [
        'dosen_id',
        'academic_period_id',
        'jenis_bimbingan',
        'kategori_bimbingan',
        'jumlah_mahasiswa',
        'semester',
        'tahun_akademik',
        'no_sk_pembimbing',
        'tanggal_sk_pembimbing',
        'no_sk_penguji',
        'tanggal_sk_penguji',
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
