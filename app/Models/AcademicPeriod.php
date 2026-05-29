<?php
// app/Models/AcademicPeriod.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicPeriod extends Model
{
    use HasFactory;

    protected $table = 'academic_periods';

    protected $fillable = [
        'nama_periode',
        'kode_periode',
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
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_active' => 'boolean',
        'is_closed' => 'boolean',
        'tahun_awal' => 'integer',
        'tahun_akhir' => 'integer',
        'urutan' => 'integer',
    ];

    // Relationships
    public function pengajarans()
    {
        return $this->hasMany(Pengajaran::class, 'academic_period_id', 'id');
    }

    public function risets()
    {
        return $this->hasMany(Riset::class, 'academic_period_id', 'id');
    }

    public function pkms()
    {
        return $this->hasMany(Pkm::class, 'academic_period_id', 'id');
    }

    public function bimbingans()
    {
        return $this->hasMany(Bimbingan::class, 'academic_period_id', 'id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCurrent($query)
    {
        return $query->where('is_active', true)->where('is_closed', false);
    }

    // Accessors
    public function getDisplayNameAttribute()
    {
        return "{$this->nama_periode} ({$this->semester} {$this->tahun_awal}/{$this->tahun_akhir})";
    }

    // Boot method - Hanya jalankan jika field kosong
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($period) {
            // Hanya set jika belum diisi
            if (empty($period->kode_periode)) {
                $period->kode_periode = $period->tahun_awal . ($period->semester == 'ganjil' ? '1' : '2');
            }

            if (empty($period->urutan)) {
                $period->urutan = $period->tahun_awal * 10 + ($period->semester == 'ganjil' ? 1 : 2);
            }
        });
    }
}
