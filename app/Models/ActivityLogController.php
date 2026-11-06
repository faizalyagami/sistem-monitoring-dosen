<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'dosen_id',
        'action',
        'module',
        'description',
        'ip_address',
        'user_agent',
        'url',
        'method',
        'old_data',
        'new_data',
        'request_data',
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
        'request_data' => 'array',
        'created_at' => 'datetime',
    ];

    // Karena hanya ada kolom created_at
    public $timestamps = false;

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    // Accessors
    public function getActionBadgeAttribute()
    {
        $badges = [
            'create' => 'success',
            'update' => 'warning',
            'delete' => 'danger',
            'login'  => 'info',
            'logout' => 'secondary',
        ];
        $color = $badges[$this->action] ?? 'primary';
        return "<span class='badge bg-{$color}'>" . ucfirst($this->action) . "</span>";
    }
}
