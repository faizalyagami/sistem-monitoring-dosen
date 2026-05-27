<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosens';

    protected $fillable = [
        'nidn',
        'nik',
        'nama',
        'email',
        'photo',
        'status',
        'pendidikan_terakhir',
        'jabatan_fungsional',
        'inpassing',
        'kepangkatan',
    ];

    protected $casts = [
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $with = [];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function pengajarans()
    {
        return $this->hasMany(Pengajaran::class, 'dosen_id', 'id');
    }

    public function sertifikasis()
    {
        return $this->hasMany(Sertifikasi::class, 'dosen_id', 'id');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'user_id', 'id');
    }

    public function risets()
    {
        return $this->hasMany(Riset::class);
    }
}
