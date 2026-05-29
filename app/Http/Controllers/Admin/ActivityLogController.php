<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with(['user', 'dosen']);

        // Filter by user
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by module
        if ($request->has('module') && $request->module) {
            $query->where('module', $request->module);
        }

        // Filter by action
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by description
        if ($request->has('search') && $request->search) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get filter options
        $users = User::all();
        $modules = ActivityLog::select('module')->distinct()->pluck('module');
        $actions = ActivityLog::select('action')->distinct()->pluck('action');

        // Get statistics
        $stats = [
            'total' => ActivityLog::count(),
            'today' => ActivityLog::today()->count(),
            'this_week' => ActivityLog::thisWeek()->count(),
            'this_month' => ActivityLog::thisMonth()->count(),
            'by_module' => ActivityLog::select('module', DB::raw('count(*) as total'))
                ->groupBy('module')
                ->get(),
            'by_action' => ActivityLog::select('action', DB::raw('count(*) as total'))
                ->groupBy('action')
                ->get(),
        ];

        return view('admin.activity-logs.index', compact('logs', 'users', 'modules', 'actions', 'stats'));
    }

    public function show(ActivityLog $activityLog)
    {
        $activityLog->load(['user', 'dosen']);
        return view('admin.activity-logs.show', compact('activityLog'));
    }

    public function destroy(ActivityLog $activityLog)
    {
        $activityLog->delete();

        return redirect()->route('admin.activity-logs.index')
            ->with('success', 'Activity log berhasil dihapus');
    }

    public function clearOldLogs()
    {
        // Delete logs older than 3 months
        $deleted = ActivityLog::where('created_at', '<', now()->subMonths(3))->delete();

        return redirect()->route('admin.activity-logs.index')
            ->with('success', "{$deleted} activity logs berhasil dihapus");
    }

    public function export(Request $request)
    {
        // This would require Laravel Excel package
        // For now, we'll redirect back
        return redirect()->back()->with('info', 'Fitur export log sedang dalam pengembangan');
    }
}
