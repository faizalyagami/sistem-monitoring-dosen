<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'dosen_id',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    /**
     * Relasi ke Dosen (tanpa foreign key constraint di database)
     * Laravel tetap bisa melakukan join
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id', 'id');
    }

    /**
     * Cek role
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDosen(): bool
    {
        return $this->role === 'dosen';
    }

    /**
     * Ambil data dosen dengan aman
     */
    public function getDataDosen()
    {
        if ($this->isDosen() && $this->dosen_id) {
            return $this->dosen;
        }
        return null;
    }

    /**
     * Scope untuk filter role
     */
    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeDosen($query)
    {
        return $query->where('role', 'dosen');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
