<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activityLogs = ActivityLog::with('petugas')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.activity-logs.index', compact('activityLogs'));
    }

    public function show($id)
    {
        $activityLog = ActivityLog::with('petugas')->findOrFail($id);
        return view('admin.activity-logs.show', compact('activityLog'));
    }
}
