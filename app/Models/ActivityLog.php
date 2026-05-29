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

    public $timestamps = false; // Using created_at only

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    // Scopes
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
    }

    public function scopeByModule($query, $module)
    {
        return $query->where('module', $module);
    }

    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    // Accessors
    public function getActionBadgeAttribute()
    {
        $badges = [
            'create' => 'success',
            'update' => 'warning',
            'delete' => 'danger',
            'login' => 'info',
            'logout' => 'secondary',
            'view' => 'primary',
            'export' => 'dark',
            'import' => 'dark',
        ];

        $color = $badges[$this->action] ?? 'secondary';
        $icons = [
            'create' => 'bi-plus-circle',
            'update' => 'bi-pencil-square',
            'delete' => 'bi-trash',
            'login' => 'bi-box-arrow-in-right',
            'logout' => 'bi-box-arrow-right',
            'view' => 'bi-eye',
            'export' => 'bi-download',
            'import' => 'bi-upload',
        ];

        $icon = $icons[$this->action] ?? 'bi-info-circle';

        return "<span class='badge bg-{$color}'><i class='{$icon} me-1'></i> {$this->action}</span>";
    }

    public function getModuleBadgeAttribute()
    {
        $badges = [
            'dosen' => 'primary',
            'pengajaran' => 'success',
            'riset' => 'info',
            'pkm' => 'warning',
            'bimbingan' => 'secondary',
            'user' => 'danger',
            'period' => 'dark',
            'auth' => 'light',
        ];

        $color = $badges[$this->module] ?? 'secondary';
        return "<span class='badge bg-{$color}'>{$this->module}</span>";
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
