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
        'status',
    ];

    protected $casts = [
        'tahun_terbit' => 'integer',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function getStatusBadgeAttribute()
    {
        if ($this->status == 'aktif') {
            return '<span class="badge bg-success">Aktif</span>';
        }
        return '<span class="badge bg-danger">Tidak Aktif</span>';
    }
}
