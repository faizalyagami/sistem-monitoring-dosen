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

    /**
     * Relasi ke User (one-to-one)
     */
    public function user()
    {
        return $this->hasOne(User::class, 'dosen_id', 'id');
    }

    /**
     * Relasi ke data kinerja
     */
    public function pengajarans()
    {
        return $this->hasMany(Pengajaran::class, 'dosen_id', 'id');
    }

    public function risets()
    {
        return $this->hasMany(Riset::class, 'dosen_id', 'id');
    }

    public function pkms()
    {
        return $this->hasMany(Pkm::class, 'dosen_id', 'id');
    }

    public function bimbingans()
    {
        return $this->hasMany(Bimbingan::class, 'dosen_id', 'id');
    }

    public function evaluasis()
    {
        return $this->hasMany(Evaluasi::class, 'dosen_id', 'id');
    }

    public function pelatihans()
    {
        return $this->hasMany(Pelatihan::class, 'dosen_id', 'id');
    }

    /**
     * Accessor untuk foto
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo && file_exists(storage_path('app/public/' . $this->photo))) {
            return asset('storage/' . $this->photo);
        }
        return 'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=' . urlencode($this->nama);
    }

    /**
     * Accessor untuk status badge
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'tetap' => 'success',
            'kontrak' => 'warning',
            'luar_biasa' => 'info',
            'pensiun' => 'secondary',
        ];

        $color = $badges[$this->status] ?? 'secondary';
        return "<span class='badge bg-{$color}'>{$this->status}</span>";
    }

    /**
     * Scope
     */
    public function scopeTetap($query)
    {
        return $query->where('status', 'tetap');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', '!=', 'pensiun');
    }
}
