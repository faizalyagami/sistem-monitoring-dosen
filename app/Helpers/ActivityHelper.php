<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityHelper
{
    /**
     * Log custom activity
     */
    public static function log($action, $module, $description, $data = null)
    {
        $user = Auth::user();

        return ActivityLog::create([
            'user_id' => $user ? $user->id : null,
            'dosen_id' => $user && $user->dosen_id ? $user->dosen_id : null,
            'action' => $action,
            'module' => $module,
            'description' => $description,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'url' => Request::fullUrl(),
            'method' => Request::method(),
            'request_data' => $data,
        ]);
    }

    /**
     * Log login activity
     */
    public static function logLogin($user)
    {
        return self::log('login', 'auth', "User {$user->name} login ke sistem");
    }

    /**
     * Log logout activity
     */
    public static function logLogout($user)
    {
        return self::log('logout', 'auth', "User {$user->name} logout dari sistem");
    }

    /**
     * Log export activity
     */
    public static function logExport($module, $format = 'excel')
    {
        return self::log('export', $module, "Export data {$module} ke format {$format}");
    }

    /**
     * Log view activity
     */
    public static function logView($module, $id = null)
    {
        $description = $id ? "Melihat detail data {$module} ID: {$id}" : "Melihat daftar data {$module}";
        return self::log('view', $module, $description);
    }
}
