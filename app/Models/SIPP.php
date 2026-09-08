<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sipp extends Model
{
    use HasFactory;

    protected $table = 'table_sipps';

    protected $fillable = [
        'dosen_id',
        'no_registrasi',
        'bidang_keilmuan',
        'tahun_terbit',
        'penerbit',
        'file_sipp',
        'status',
        'tanggal_terbit',
        'tanggal_kadaluarsa',
        'keterangan',
    ];

    protected $casts = [
        'tahun_terbit' => 'integer',
        'tanggal_terbit' => 'date',
        'tanggal_kadaluarsa' => 'date',

    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'aktif' => 'success',
            'kadaluarsa' => 'warning',
            'dicabut' => 'danger',
        ];

        $texts = [
            'aktif' => 'Aktif',
            'kadaluarsa' => 'Kadaluarsa',
            'dicabut' => 'Dicabut',
        ];

        $color = $badges[$this->status] ?? 'secondary';
        return "<span class='badge bg-{$color}'>{$texts[$this->status]}</span>";
    }

    public function getIsActiveAttribute()
    {
        if ($this->status != 'aktif') {
            return false;
        }

        if ($this->tanggal_kadaluarsa && now() > $this->tanggal_kadaluarsa) {
            return false;
        }

        return true;
    }
}
