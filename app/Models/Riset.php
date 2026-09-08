<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riset extends Model
{
    use HasFactory;

    protected $table = 'table_risets';

    protected $fillable = [
        'dosen_id',
        'academic_period_id',
        'judul_riset',
        'bidang_riset',
        'jenis_riset',
        'sumber_dana',
        'jumlah_dana',
        'status',
        'publikasi_link',
        'kolaborator',
        'file_laporan',
        'tahun',
    ];

    protected $casts = [
        'jumlah_dana' => 'integer',
        'tahun' => 'integer',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id');
    }

    public function academicPeriod()
    {
        return $this->belongsTo(AcademicPeriod::class, 'academic_period_id', 'id');
    }

    public function getFormattedDanaAttribute()
    {
        return 'Rp ' . number_format($this->jumlah_dana, 0, ',', '.');
    }

    public function getStatusBadgeAttribute()
    {
        $color = $this->status == 'aktif' ? 'success' : 'secondary';
        return "<span class='badge bg-{$color}'>{$this->status}</span>";
    }
}
