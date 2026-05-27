<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeriodeAkademik extends Model
{
    use HasFactory;

    protected $table = 'academic_periods';

    protected $fillable = [
        'nama_periode',
        'tahun_ajaran',
        'semester',
        'tahun_awal',
        'tahun_akhir',
        'tanggal_mulai',
        'tanggal_selesai',
        'is_active',
        'is_closed',
        'keterangan',
        'urutan',
    ];

    protected $casts = [
        'tahun_awal' => 'integer',
        'tahun_akhir' => 'integer',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_active' => 'boolean',
        'is_closed' => 'boolean',
        'urutan' => 'integer',
    ];

    public function pengajarans()
    {
        return $this->hasMany(Pengajaran::class, 'academic_period_id');
    }

    public function bimbingans()
    {
        return $this->hasMany(Bimbingan::class, 'academic_period_id');
    }

    public function evaluasis()
    {
        return $this->hasMany(Evaluasi::class, 'academic_period_id');
    }

    public function risets()
    {
        return $this->hasMany(Riset::class, 'academic_period_id');
    }

    public function pkms()
    {
        return $this->hasMany(PKM::class, 'academic_period_id');
    }

    public function sertifikasis()
    {
        return $this->hasMany(Sertifikasi::class, 'academic_period_id');
    }

    public function pelatihans()
    {
        return $this->hasMany(Pelatihan::class, 'academic_period_id');
    }

    public function suratTugas()
    {
        return $this->hasMany(SuratTugas::class, 'academic_period_id');
    }

    public function asosiasis()
    {
        return $this->hasMany(Asosiasi::class, 'academic_period_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOpen($query)
    {
        return $query->where('is_closed', false);
    }

    public function getNamaLengkapAttribute(): string
    {
        return "{$this->nama_periode} ({$this->semester} {$this->tahun_awal}/{$this->tahun_akhir})";
    }

    public function isCurrentPeriode(): bool
    {
        return $this->is_active && !$this->is_closed;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($periode) {
            if (empty($periode->kode_periode)) {
                $tahun = $periode->tahun_awal;
                $semester = $periode->semester == 'ganjil' ? '1' : '2';
                $periode->kode_periode = $tahun . $semester;
            }

            if (empty($periode->urutan)) {
                $periode->urutan = $periode->tahun_awal * 10 + ($periode->semester == 'ganjil' ? 1 : 2);
            }
        });
    }
}
