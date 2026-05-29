<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    /**
     * Log activity for model events
     */
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            $model->logActivity('create', $model->toArray());
        });

        static::updated(function ($model) {
            $model->logActivity('update', $model->getChanges(), $model->getOriginal());
        });

        static::deleted(function ($model) {
            $model->logActivity('delete', null, $model->toArray());
        });
    }

    /**
     * Log activity
     */
    public function logActivity($action, $newData = null, $oldData = null)
    {
        $user = Auth::user();

        ActivityLog::create([
            'user_id' => $user ? $user->id : null,
            'dosen_id' => $user && $user->dosen_id ? $user->dosen_id : null,
            'action' => $action,
            'module' => $this->getModuleName(),
            'description' => $this->getActivityDescription($action),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'url' => Request::fullUrl(),
            'method' => Request::method(),
            'old_data' => $oldData,
            'new_data' => $newData,
            'request_data' => $action === 'create' ? $newData : null,
        ]);
    }

    /**
     * Get module name from model
     */
    protected function getModuleName()
    {
        $className = class_basename($this);
        return strtolower(str_replace('App\\Models\\', '', $className));
    }

    /**
     * Get activity description
     */
    protected function getActivityDescription($action)
    {
        $moduleName = $this->getModuleFriendlyName();

        switch ($action) {
            case 'create':
                return "Menambahkan data {$moduleName} baru";
            case 'update':
                return "Mengupdate data {$moduleName}";
            case 'delete':
                return "Menghapus data {$moduleName}";
            default:
                return "Melakukan {$action} pada data {$moduleName}";
        }
    }

    /**
     * Get friendly module name
     */
    protected function getModuleFriendlyName()
    {
        $names = [
            'dosen' => 'Dosen',
            'pengajaran' => 'Pengajaran',
            'riset' => 'Penelitian',
            'pkm' => 'PKM',
            'bimbingan' => 'Bimbingan',
            'user' => 'User',
            'academicperiod' => 'Periode Akademik',
        ];

        $module = strtolower(class_basename($this));
        return $names[$module] ?? $module;
    }
}
