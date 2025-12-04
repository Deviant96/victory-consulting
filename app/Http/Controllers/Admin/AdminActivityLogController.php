<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class AdminActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = AdminActivityLog::query()
            ->with('user')
            ->when($request->filled('admin'), function ($query) use ($request) {
                $query->where('user_id', $request->integer('admin'));
            })
            ->when($request->filled('action'), function ($query) use ($request) {
                $query->where('action', 'like', '%' . $request->string('action') . '%');
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $admins = User::whereIn('id', AdminActivityLog::select('user_id')->whereNotNull('user_id'))
            ->orderBy('name')
            ->get();

        return view('admin.activity-logs.index', compact('logs', 'admins'));
    }
}
