<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use Illuminate\Http\Request;

class AdminLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = AdminLog::query()
            ->with('user')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $stats = [
            'day' => AdminLog::where('created_at', '>=', now()->subDay())->count(),
            'week' => AdminLog::where('created_at', '>=', now()->subDays(7))->count(),
            'total' => AdminLog::count(),
        ];

        return view('admin.logs.index', compact('logs', 'stats'));
    }
}
